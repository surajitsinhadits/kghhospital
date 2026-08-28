<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Cache;
use App\Models\StVendor;

class AuthController extends Controller
{
    public function check_user(Request $request)
    {
        $credentials = $request->validate([
            'userid' => 'required',
            'password' => 'required',
        ]);

        $user = User::where([
            ['empId', $credentials['userid']],
            ['is_active', 1],
            ['is_delete', 0]
        ])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

        // Non-vendor: fetch permissions and store in session
        $permissions = Cache::rememberForever('role_permissions_' . $user->role_id, function () use ($user) {
            return Permission::select('permissions.permissions')
                ->join('role_has_permissions as rhp', 'rhp.permission_id', '=', 'permissions.id')
                ->where('rhp.role_id', $user->role_id)
                ->pluck('permissions')
                ->map(function ($permission) {
                    return trim($permission);
                })
                ->toArray();
        });

        $request->session()->put('permissions', $permissions);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Successfully logged In!');
    }

    public function check_vendor(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $vendor = StVendor::where([
            ['email', $credentials['email']],
            ['is_active', 1],
            ['is_delete', 0]
        ])->first();

        if (!$vendor || !Hash::check($credentials['password'], $vendor->password)) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

        Session::put('email', $vendor->email);
        Session::put('vendor_id', $vendor->id);
        Session::put('vendor_name', $vendor->vendor_name);
        return redirect()->route('vendor-dashboard')->with('success', 'Successfully logged In!');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Successfully logged Out!');
    }

    public function vendorLogout()
    {
        if( Session::get('email') ){
            session()->flush();
        }
        return redirect()->route('vendor.login')->with('success', 'Successfully logged Out!');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('email', $request->email);

        Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json(['status' => true, 'message' => 'OTP Sent!']);
    }

    public function verifyOtp(Request $request)
    {
        if ($request->otp == Session::get('otp')) {
            return response()->json(['status' => true, 'message' => 'OTP Verified!']);
        }
        return response()->json(['status' => false, 'message' => 'Invalid OTP!']);
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', Session::get('email'))->first();
        $user->password = Hash::make($request->password);
        $user->save();

        Session::forget(['otp', 'email']);

        return response()->json(['status' => true, 'message' => 'Password Reset Successful!']);
    }
    public function change_password()
    {
        return view('hr.change-password');
    }
    public function save_change_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required',
        ]);
        $hashedPassword = Auth::user()->password;

        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->new_password, $hashedPassword)) {
                if ($request->new_password == $request->confirm_password) {

                    $users = User::find(Auth::id());
                    $users->password = Hash::make($request->new_password);
                    $users->save();

                    session()->flash('success', 'Password updated successfully!');
                    return redirect()->route('hr.users-info', ed(Auth::id(), true));
                } else {
                    session()->flash('error', 'New password does not matched with Confirm password!');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'New password can not be the old password!');
                return redirect()->back();
            }
        } else {
            session()->flash('error', 'Old password does not matched! ');
            return redirect()->back();
        }
    }
}
