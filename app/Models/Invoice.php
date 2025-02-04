<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Invoice extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function arrangement(): HasOneThrough
    {
        return $this->hasOneThrough(
            related: Arrangement::class,
            through: Entry::class,
            firstKey: 'invoice_id',
            secondKey: 'id',
            localKey: 'id',
            secondLocalKey: 'arrangement_id'
        );
    }

    public function shortUlid(): Attribute
    {
        return Attribute::make(
            get: fn(): string => str($this->id)->substr(-12)->upper(),
        );
    }

    public function total(): Attribute
    {
        return Attribute::make(
            get: fn(): Money => Money::sum(
                ...$this->entries->map(
                fn(Entry $entry): Money => $entry->earnings,
            )),
        );
    }

    public function hours(): Attribute
    {
        return Attribute::make(
            get: fn(): float => $this->entries->sum('hours'),
        );
    }
}
