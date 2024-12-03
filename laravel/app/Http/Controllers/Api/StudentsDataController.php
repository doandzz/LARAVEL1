<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentsDataController extends Controller
{
    public function storeTrackingData(Request $request)
    {
        try {
            $imageData = $request->input('image');
            $path = $request->input('path');
            $publicPath = public_path($path);

            
            $directory = dirname($publicPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            
            // $image = explode(',', $imageData)[1];
            $imageData = stripslashes($imageData);
            $imageDecoded = base64_decode($imageData);

            if ($imageDecoded === false) {
                return response()->json('data Base64 invalid.');
            }
            if(file_put_contents($publicPath, $imageDecoded))
            {
                return response()->json(['message' => 'Image saved successfully', 'path' => $publicPath], 200);
            }else{
                return response()->json(['message' => 'Cant Save Image'], 500);
            }

            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
