<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'division_id',
        'status'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function group()
    {
        return $this->division->group();
    }

    public function headOfficeUser()
    {
        return $this->hasMany(user_has_head_office::class);
    }


    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhereHas('division', function ($d) use ($value) {
                $d->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('division.group', function ($g) use ($value) {
                $g->where('name', 'like', "%{$value}%");
            });
    }
}
