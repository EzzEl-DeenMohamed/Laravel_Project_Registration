<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploaderService
{
    /**
     * Upload a file and return its path.
     *
     * @param Request $request
     * @return string
     */
    public function uploadFileAndReturnPath(Request $request): string
    {
        // Check if the request contains a file
        if ($request->hasFile('image_url')) {
            // Validate the file (optional)
            $request->validate([
                'image_url' => 'required|file|mimes:jpg,png,pdf,doc,docx|max:2048',
            ]);

            // Retrieve the file from the request
            $file = $request->file('image_url');

            // Define a file path to store the file
            $filePath = 'uploads/' . time() . '_' . $file->getClientOriginalName();

            // Store the file in the storage/app/uploads directory
            Storage::put($filePath, file_get_contents($file));

            return $filePath;
        }

        return '';
    }
}
