<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Client\Client;
use App\Models\Directory\RepresentativePositionDirectory;


class ClientRepresentative extends Model
{
    protected $fillable = [
        'id',
        'name',
        'email',
        'surname',
        'patronymic',  // отчество
        'phone',
        'representative_position_id',
        'client_id',
        'deleted_at',
    ];

    public function client(): BelongsTo 
    {
        return $this->belongsTo(Client::class);
    }

    public function representativePosition():BelongsTo 
    {
        return $this->belongsTo(RepresentativePositionDirectory::class);
    }

}
