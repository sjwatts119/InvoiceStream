<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entry extends Model
{
    use HasUlids;
    use HasFactory;

    protected $fillable = [
        'id',
        'arrangement_id',
        'hours',
        'rate',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function arrangement(): BelongsTo
    {
        return $this->belongsTo(Arrangement::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function rawTotal(): Attribute
    {
        return Attribute::make(
            get: fn (): float => $this->hours * $this->rate,
        );
    }

    public function earned(): Attribute
    {
        return Attribute::make(
            get: fn (): Money => Money::parseByDecimal($this->rawTotal, $this->arrangement->currency),
        );
    }

    public function formattedRate(): Attribute
    {
        return Attribute::make(
            get: fn (): string => Money::parseByDecimal($this->rate, $this->arrangement->currency),
        );
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->invoice ? 'Invoiced' : 'Uninvoiced',
        );
    }

    public function invoiced(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->invoice !== null,
        );
    }
}
