<?php

namespace App\Models\Counterparty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Directory\CounterpartyTypeDirectory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Counterparty\CounterpartyRepresentative;


class Counterparty extends Model
{
    protected $fillable = [
        'id',
        'name',
        'counterparty_type_id', // вид контрагента
        'inn',
        'city',
        'address',
                        // Предстовитель
        'deleted_at',
    ];

    public function counterpartyType(): BelongsTo 
    {
        return $this->belongsTo(CounterpartyTypeDirectory::class);
    }
    public function representatives(): HasMany
    {
        return $this->hasMany(CounterpartyRepresentative::class)->where('deleted_at', null);
    }
}
