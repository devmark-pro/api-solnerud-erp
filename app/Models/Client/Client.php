<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Directory\CounterpartyTypeDirectory;
use App\Models\Client\ClientRepresentative;

use Illuminate\Database\Eloquent\Model;

  
class Client extends Model
{
    protected $fillable = [
        'id',
        'name',
        'inn',
        'city',
        'address',
        'created_at',
        'deleted_at',

    ];

    public function representatives(): HasMany
    {
        return $this->hasMany(ClientRepresentative::class)->where('deleted_at', null);
    }
}
