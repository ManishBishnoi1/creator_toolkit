<?php

namespace App\Modules\Downloader\Services;

class ScrapingProxyRotator
{
    protected array $proxies = [];
    protected int $currentIndex = 0;

    public function __construct()
    {
        // In production, this can load from a config, DB table, or Redis cache
        $this->proxies = config('tools.instagram.proxies', [
            'http://proxy1.example.com:8080',
            'http://proxy2.example.com:8080',
            'http://proxy3.example.com:8080',
        ]);
    }

    /**
     * Get the next proxy in a round-robin fashion.
     */
    public function getNextProxy(): ?string
    {
        if (empty($this->proxies)) {
            return null;
        }

        $proxy = $this->proxies[$this->currentIndex];
        
        // Move to the next index
        $this->currentIndex = ($this->currentIndex + 1) % count($this->proxies);
        
        return $proxy;
    }
}
