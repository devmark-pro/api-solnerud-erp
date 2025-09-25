<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User\User;


class UserDocument extends Model
{
    protected $fillable = [
        'id',
        'date',
        'name',
        'file',
        'added_user_id',
        'comment',        
        'user_id',
        'deleted_at',
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function addedUser(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'added_user_id');
    }
}

