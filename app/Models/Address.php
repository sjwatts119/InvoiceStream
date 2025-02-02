<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Address extends Model
{
    use HasFactory;
    use HasUlids;
    protected $fillable = [
        'line_1',
        'line_2',
        'city',
        'country',
        'postal_code',
    ];

    public function addressLines(): Attribute
    {
        return Attribute::make(
            get: fn(): Collection => collect([
                $this->line_1,
                $this->line_2,
                $this->city,
                $this->country,
                $this->postal_code,
            ])
            ->filter(),
        );
    }
}
