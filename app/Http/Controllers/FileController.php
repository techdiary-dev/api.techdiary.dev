<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\FileDeleteRequest;
use App\Http\Requests\File\FileUploadRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileController extends Controller
{
    public function upload(FileUploadRequest $request): \Illuminate\Http\JsonResponse
    {
        $uploadedFiles = collect($request->file('files'))->map(function ($file) {
            $upload = Cloudinary::upload($file->getRealPath());

            return [
                'url' => $upload->getSecurePath(),
                'file' => [
                    'key' => $upload->getPublicId(),
                    'provider' => 'cloudinary',
                ],
            ];
        });

        return response()->json([
            'message' => 'Files uploaded successfully',
            'files' => $uploadedFiles,
        ]);
    }

    public function destroy(FileDeleteRequest $request)
    {
        collect($request->get('keys'))->each(function ($file) {
            Cloudinary::destroy($file);
        });

        return response()->json([
            'message' => 'File deleted successfully',
            'deleted' => $request->get('keys'),
        ]);
    }
}
