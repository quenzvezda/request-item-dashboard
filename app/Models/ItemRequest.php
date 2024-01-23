<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'tanggal_permintaan',
    ];

    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function itemRequestDetails()
    {
        return $this->hasMany(ItemRequestDetail::class);
    }
}
