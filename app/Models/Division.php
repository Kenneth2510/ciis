<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'group_id',
        'status'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function headOfficeUser()
    {
        return $this->hasMany(user_has_head_office::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhereHas('group', function ($g) use ($value) {
                $g->where('name', 'like', "%{$value}%");
            });
    }
}
