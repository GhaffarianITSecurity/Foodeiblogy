<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadSampleImages extends Command
{
    protected $signature = 'download:sample-images';
    protected $description = 'Download sample images for posts';

    public function handle()
    {
        // Create posts directory if it doesn't exist
        if (!Storage::disk('public')->exists('posts')) {
            Storage::disk('public')->makeDirectory('posts');
        }

        $images = [
            'ghormeh-sabzi.jpg' => 'https://picsum.photos/800/600?random=1',
            'fesenjan.jpg' => 'https://picsum.photos/800/600?random=2',
            'baghali-polo.jpg' => 'https://picsum.photos/800/600?random=3',
            'baklava.jpg' => 'https://picsum.photos/800/600?random=4',
            'abgoosht.jpg' => 'https://picsum.photos/800/600?random=5',
            'bidmeshk.jpg' => 'https://picsum.photos/800/600?random=6',
        ];

        foreach ($images as $filename => $url) {
            $this->info("Downloading {$filename}...");
            
            try {
                // Create a temporary file
                $tempFile = tempnam(sys_get_temp_dir(), 'img_');
                
                // Download the image
                $imageContent = file_get_contents($url);
                if ($imageContent === false) {
                    throw new \Exception("Failed to download image from {$url}");
                }
                
                // Store in the public disk
                Storage::disk('public')->put("posts/{$filename}", $imageContent);
                
                // Clean up
                unlink($tempFile);
                
                $this->info("Downloaded {$filename}");
            } catch (\Exception $e) {
                $this->error("Failed to download {$filename}: " . $e->getMessage());
            }
        }

        $this->info('All images downloaded successfully!');
    }
} 