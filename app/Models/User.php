<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
		'empId',
		'role_id',
		'salutation',
		'name',
		'email',
		'password',
		'phone_no',
		'father_name',
		'mother_name',
		'gender',
		'marital_status',
		'blood_group',
		'dob',
		'joining_date',
		'whatsapp_no',
		'emg_no',
		'profile_img',
		'current_address',
		'permanent_address',
		'qualification',
		'experience',
		'specialization',
		'note',
		'pan_number',
		'identification_name',
		'identification_number',
		'signature',
		'department_id',
		'category_id',
		'sub_category_id',
		'doctor_type',
        'doctor_fees',
		'charge_id',
		'commission_type',
		'commission_amount',
        'salary_master_id',
        'basic_salary',
		'user_type',
		'is_active',
		'is_delete'
	];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
		'password'
	];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
