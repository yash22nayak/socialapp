<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function sentFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    public function receivedFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    public function friends()
    {
        return User::where(function ($query) {
            $query->whereHas('sentFriendRequests', function ($query) {
                $query->where('receiver_id', $this->id)
                    ->where('status', 'accept');
            })
                ->orWhereHas('receivedFriendRequests', function ($query) {
                    $query->where('sender_id', $this->id)
                        ->where('status', 'accept');
                });
        });
    }

    public function isFriendsWith($user)
    {
        return $this->friends()->where('id', $user->id)->exists();
    }

    public function hasSentRequestTo($user)
    {
        return $this->sentFriendRequests()->where('receiver_id', $user->id)->where('status', 'sent')->first();
    }

    public function hasReceivedRequestFrom($user)
    {
        return $this->receivedFriendRequests()->where('sender_id', $user->id)->where('status', 'sent')->first();
    }
}
