<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\FileDeleteRequest;
use App\Http\Requests\File\FileUploadRequest;
use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Delivery;
use Cloudinary\Transformation\Format;
use Cloudinary\Transformation\Quality;

class FileController extends Controller
{
    public function upload(FileUploadRequest $request)
    {
        $cld = new Cloudinary();

        $public_id = cloudinary()->upload(
            $request->file('file')->getRealPath(),
            [
                "upload_preset" => $request->get('preset')
            ]
        )->getPublicId();

        $url = (string)$cld->image($public_id)
            ->delivery(
                Delivery::format(Format::auto())
            )->delivery(
                Delivery::quality(Quality::auto())
            )->toUrl();


        return response()->json([
            'message' => 'File uploaded successfully',
            'url' => explode("?", $url)[0]
        ]);
    }

    public function destroy(FileDeleteRequest $request)
    {

        $file_url = $request->file_url;
        $split = explode("/", $file_url);
        $public_id = implode("/", array_slice($split, -2));

        $cld_admin = new AdminApi();

        $deleted = $cld_admin->deleteAssets([
            $public_id
        ]);


        return response()->json([
            'message' => 'File deleted successfully',
            "deleted" => $deleted
        ]);
    }
}
