<?php

namespace App\Models;

use Database\Factories\CampaignFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug', 'description', 'image_path', 'target_amount', 'deadline'])]
class Campaign extends Model
{
    /** @use HasFactory<CampaignFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'target_amount' => 'integer',
        ];
    }

    /**
     * @return HasMany<Donation, $this>
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function totalVerifiedAmount(): int
    {
        return (int) $this->donations()->where('status', 'verified')->sum('amount');
    }

    public function progressPercentage(): float
    {
        if ($this->target_amount <= 0) {
            return 100.0;
        }

        return min(100.0, round(($this->totalVerifiedAmount() / $this->target_amount) * 100, 1));
    }

    public function remainingDays(): int
    {
        return max(0, (int) now()->startOfDay()->diffInDays($this->deadline, false));
    }

    public function isCompleted(): bool
    {
        if (now()->startOfDay()->gt($this->deadline)) {
            return true;
        }

        if ($this->totalVerifiedAmount() >= $this->target_amount) {
            return true;
        }

        return false;
    }
}
