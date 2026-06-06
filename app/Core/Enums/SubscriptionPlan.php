<?php

namespace App\Core\Enums;

enum SubscriptionPlan: string
{
    case FREE = 'free';
    case PREMIUM = 'premium';
    case ENTERPRISE = 'enterprise';

    /**
     * Get label for display.
     */
    public function label(): string
    {
        return match ($this) {
            self::FREE => 'Free Tier',
            self::PREMIUM => 'Premium Pro',
            self::ENTERPRISE => 'Enterprise / Studio',
        };
    }

    /**
     * Check if plan gets unlimited scraper/generator limits.
     */
    public function isUnlimited(): bool
    {
        return $this === self::ENTERPRISE;
    }
}
