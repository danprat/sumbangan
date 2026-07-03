<?php

namespace App\Models;

use Database\Factories\DonationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable(['campaign_id', 'token', 'donor_name', 'donor_email', 'donor_phone', 'amount', 'proof_image_path', 'status', 'admin_notes', 'verified_at'])]
class Donation extends Model
{
    /** @use HasFactory<DonationFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Donation $donation) {
            if (empty($donation->token)) {
                $donation->token = (string) Str::orderedUuid();
            }
        });
    }

    /**
     * @return BelongsTo<Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'amount' => 'integer',
        ];
    }
}
