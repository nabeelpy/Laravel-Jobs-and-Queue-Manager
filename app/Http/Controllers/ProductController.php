<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCSVUpload;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function uploadCSVFromPaths(Request $request)
    {
        // Validate input
//        $request->validate([
//            'file_paths' => 'required|array',
//            'file_paths.*' => 'string',
//        ]);

        $file_paths = [
            'C:\xampp\htdocs\Concurrency\public\products_25000.csv',
            'C:\xampp\htdocs\Concurrency\public\products_35000.csv',
            'C:\xampp\htdocs\Concurrency\public\products_15000.csv'];

        // Dispatch each file for concurrent processing
        foreach ($file_paths as $filePath) {
            dispatch(new ProcessCSVUpload($filePath));
//            $this->csvUpload($filePath);
        }

        return response()->json(['message' => 'CSV upload started in the background!'], 202);
    }

     public function csvUpload($filePath)
    {

        if (($handle = fopen($filePath, "r")) !== false) {
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
//                    dd($batchData);
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
