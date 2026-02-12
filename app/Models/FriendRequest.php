<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class FriendRequest extends Model
{
    /** @use HasFactory<\Database\Factories\FriendRequestFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
        'unfriended_by_id',
        'accepted_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const ACCEPT = 'accept';
    public const REJECT = 'reject';
    public const SENT = 'sent';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'accepted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        parent::booted();

        static::deleting(function ($friendRequest) {
            $friendRequest->update([
                'unfriended_by_id' => Auth::id(),
            ]);
        });

        static::creating(function ($friendRequest) {
            $friendRequest->sender_id = Auth::id();
        });

        static::updating(function ($friendRequest) {
            if ($friendRequest->status === self::ACCEPT) {
                $friendRequest->accepted_at = now();
            }
        });
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function unfriendedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'unfriended_by_id');
    }
}
