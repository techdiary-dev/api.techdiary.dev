<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\FileDeleteRequest;
use App\Http\Requests\File\FileUploadRequest;
use Cloudinary\Api\Admin\AdminApi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileController extends Controller
{
    public function upload(FileUploadRequest $request)
    {
        $upload = Cloudinary::upload($request->file('file')->getRealPath());

        return response()->json([
            'message' => 'File uploaded successfully',
            'url' => $upload->getSecurePath(),
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
