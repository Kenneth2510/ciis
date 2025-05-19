<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        // 'name',
        'employee_id',
        'email',
        'company',
        'position',
        'password',
        'isReset',
        'isBranch',
        'status',
        'expiration_date',
        'profile_picture',
        'password_changed_at',
        'failed_attempts',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeSearch($query, $value)
    {
        $query->where('fname', 'like', "%{$value}%")
        ->orWhere('mname', 'like', "%{$value}%")
        ->orWhere('lname', 'like', "%{$value}%")
        ->orWhere('employee_id', 'like', "%{$value}%")
        ->orWhere('email', 'like', "%{$value}%")
        ->orWhere('company', 'like', "%{$value}%")
        ->orWhereHas('role', function ($q) use ($value) {
            $q->where('name', 'like', "%{$value}%");
        });
    }

    public function branchUser()
    {
        return $this->hasOne(user_has_branch::class);
    }

    public function headOfficeUser()
    {
        return $this->hasOne(user_has_head_office::class);
    }
}
