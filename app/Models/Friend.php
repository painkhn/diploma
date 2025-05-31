<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status'
    ];

    // Отправитель запроса
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Получатель запроса
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}