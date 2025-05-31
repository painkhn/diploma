<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'name',
        'email',
        'avatar',
        'password',
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

    public function projectUser()
    {
        return $this->hasOne(ProjectUser::class);
    }

    // public function tasks()
    // {
    //     return $this->hasMany(User::class);
    // }

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function Report()
    {
        return $this->hasMany(Report::class);
    }

    // Запросы, которые пользователь отправил
    public function sentFriendRequests()
    {
        return $this->hasMany(Friend::class, 'sender_id');
    }

    // Запросы, которые пользователь получил
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friend::class, 'receiver_id');
    }

    // Все принятые друзья (как отправитель и как получатель)
    public function friends()
    {
        return Friend::where(function($query) {
                $query->where('sender_id', $this->id)
                    ->orWhere('receiver_id', $this->id);
            })
            ->where('status', 'accepted')
            ->get()
            ->map(function($friend) {
                return $friend->sender_id == $this->id ? $friend->receiver : $friend->sender;
            });
    }
}
