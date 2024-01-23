<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'departmen_id',
        'user_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmen_id');
    }

    public function itemRequests()
    {
        return $this->hasMany(ItemRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
