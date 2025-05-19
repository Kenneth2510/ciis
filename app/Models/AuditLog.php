<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    
    protected $fillable = [
        'user_id',
        'event',
        'model',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
    ];


    protected $cast = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('model', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%")
            ->orWhere('event', 'like', "%{$value}%")
            ->orWhereHas('user', function ($u) use ($value) {
                $u->where('fname', 'like', "%{$value}%")
                    ->orWhere('mname', 'like', "%{$value}%")
                    ->orWhere('lname', 'like', "%{$value}%");
            });
    }
}
