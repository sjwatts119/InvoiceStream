<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Arrangement extends Model
{
    use HasUlids;
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'description',
        'currency',
        'rate',
        'name',
        'notes',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoices(): HasManyThrough
    {
        return $this->hasManyThrough(
            related: Invoice::class,
            through: Entry::class,
            firstKey: 'arrangement_id',
            secondKey: 'id',
            localKey: 'id',
            secondLocalKey: 'invoice_id',
        )->distinct();
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query
            ->when(
                value: $search,
                callback: function (Builder $query, string $search): Builder {
                    return $query
                        ->whereLike('name', "%{$search}%")
                        ->orWhereLike('description', "%{$search}%");
                },
            );
    }

    public function notInvoicedEarnings(): Attribute
    {
        return Attribute::make(
            get: function (): Money {
                $entries = $this->entries()->notInvoiced()->get();

                $earnings = $entries->count() > 0
                    ? Money::sum(...$entries->map(fn (Entry $entry): Money => $entry->earnings))
                    : null;

                return $earnings ?? new Money(0, $this->currency);
            }
        );
    }

    public function earnings(): Attribute
    {
        return Attribute::make(
            get: function (): Money {
                $earnings = $this->entries->isNotEmpty()
                    ? Money::sum(...$this->entries->map(fn (Entry $entry): Money => $entry->earnings))
                    : null;

                return $earnings ?? new Money(0, $this->currency);
            }
        );
    }

    public function hours(): Attribute
    {
        return Attribute::make(
            get: fn (): float => $this->entries->sum('hours'),
        );
    }
}
