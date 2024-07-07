<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class File extends Controller
{
    public function handleImage(Request $request)
    {
        // Decode the path
        $path = urldecode($request->path);

        $pathToFile = storage_path('app/' . $path);
        $headers = [
            'Content-Type' => mime_content_type($pathToFile),
            'Content-Length' => filesize($pathToFile),
        ];

        return response()->file($pathToFile, $headers);
    }

    public function handlePDF(Request $request)
    {
    }
}
