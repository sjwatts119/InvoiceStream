<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected $casts = [
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

    public function earned(): Attribute
    {
        return Attribute::make(
            get: fn (): Money => Money::sum(
                ...$this->entries->map(
                    fn (Entry $entry) => $entry->earned,
                )
            ),
        );
    }

    public function hours(): Attribute
    {
        return Attribute::make(
            get: fn (): float => $this->entries->sum('hours'),
        );
    }
}
