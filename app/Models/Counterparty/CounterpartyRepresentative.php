<?php

namespace App\Models\Counterparty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Counterparty\Counterparty;
use App\Models\Directory\RepresentativePositionDirectory;


class CounterpartyRepresentative extends Model
{
    protected $fillable = [
        'id',
        'name',
        'email',
        'surname',
        'patronymic',  // отчество
        'phone',
        'representative_position_id',
        'counterparty_id',
        'deleted_at',
    ];

    public function counterparty(): BelongsTo 
    {
        return $this->belongsTo(Counterparty::class);
    }

    public function representativePosition():BelongsTo 
    {
        return $this->belongsTo(RepresentativePositionDirectory::class);
    }
}

