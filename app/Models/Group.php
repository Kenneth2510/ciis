<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function headOfficeUser()
    {
        return $this->hasMany(user_has_head_office::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%");
    }
}
