<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCSVUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        if (($handle = fopen($this->filePath, "r")) !== false) {
            // Skip the header row
            fgetcsv($handle);

            $batchData = [];

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $batchData[] = [
                    'product_name' => $data[1], // Assuming 2nd column is product_name
                    'price' => $data[2],        // Assuming 3rd column is price
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert in batches of 500 for efficiency
                if (count($batchData) >= 500) {
                    Product::insert($batchData);
                    $batchData = [];
                }
            }

            // Insert remaining records
            if (!empty($batchData)) {
                Product::insert($batchData);
            }

            fclose($handle);
        }
    }
}
