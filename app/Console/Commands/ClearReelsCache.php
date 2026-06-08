<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearReelsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reels:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all downloaded Instagram Reel files and their metadata from the storage cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = storage_path('app/public/reels');

        if (!File::exists($directory)) {
            $this->info("Reels cache directory does not exist yet.");
            return Command::SUCCESS;
        }

        $files = File::files($directory);
        $deletedCount = 0;

        foreach ($files as $file) {
            // Protect .gitignore file
            if ($file->getFilename() === '.gitignore') {
                continue;
            }

            File::delete($file->getPathname());
            $deletedCount++;
        }

        $this->info("Successfully deleted {$deletedCount} cached files from {$directory}.");
        return Command::SUCCESS;
    }
}
