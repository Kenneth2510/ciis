<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'branch_code',
        'location',
        'status'
    ];


    public function branchUser():HasMany
    {
        return $this->hasMany(user_has_branch::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('branch_code', 'like', "%{$value}%")
            ->orWhere('location', 'like', "%{$value}%");
    }
}
