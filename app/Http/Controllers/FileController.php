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
//        $upload = Cloudinary::upload($request->file('file'));
//
//        return response()->json([
//            'message' => 'File uploaded successfully',
//            'url' => $upload,
//        ]);
    }

    public function destroy(FileDeleteRequest $request)
    {
        $cld_admin = new AdminApi();
        $deleted = $cld_admin->deleteAssets($request->keys);

        return response()->json([
            'message' => 'File deleted successfully',
            'deleted' => $deleted,
        ]);
    }
}
