<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Permission;
use App\Models\RoleHasPermission;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required'],
            'password' => ['required'],
        ]);
        $user = User::where('empId', 'like', $request->email . '%')->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'data'    => null,
                'message' => 'Invalid credentials ❌'
            ], 401);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        $user->profile_img = asset('public/assets/images/users/' . $user->profile_img);
		$role = RoleHasPermission::where('role_id', $user->role_id)->pluck('permission_id');
        $user->permissions = Permission::whereIn('id', $role)
            ->where('permissions', 'like', '%Approval%')
            ->get();
        return response()->json([
            'success'  => true,
            'data'    => [
                'user'         => $user,
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ],
            'message' => 'Login Successfully ✅'
        ]);
    }

    public function patient_login(Request $request) {
        $patient = Patient::wherePhone($request->phone)->first();

        if(!$patient){
            return response()->json([
                'status'  => false,
                'data'    => null,
                'message' => 'Patient not found ❌'
            ], 401);
        }

        $token = $patient->createToken('api-token')->plainTextToken;

        return response()->json([
            'data' => $patient,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
