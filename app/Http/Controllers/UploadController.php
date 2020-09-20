<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file_type' => 'required',
            'attachment' => 'required|mimes:jpeg,bmp,png,jpg,gif'
        ]);
        try {
            $image = file_get_contents($request->attachment);
            // alternatively specify an URL, if PHP settings allow
            $imageData = base64_encode($image);
            $src = 'data: ' . $request->attachment->getClientOriginalExtension() . ';base64,' . $imageData;
//        dd($src);
//        dd($request->all());
            $upload = new Upload();
            $upload->file_type = $request->file_type;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $imageType = $file->getClientOriginalExtension();
                if ($request->file_type == 'passport') {
                    $image_resize = Image::make($file)->resize(null, 150, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($imageType);

                } elseif ($request->file_type == 'nid') {
                    $image_resize = Image::make($file)->resize(null, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($imageType);
                } else {
                    $image_resize = Image::make($file)->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($imageType);
                }
                $upload->attachment = $image_resize;
                $upload->image_type = $imageType;
            }
            $upload->save();
            return redirect()->back()->with('status', 'File uploaded successfully!');
        } catch (QueryException $ex) {
            return redirect()->back()->with('status', $ex->errorInfo[2]);
        } catch (Exception $ex) {
            return redirect()->back()->with('status', $ex->getMessage());

        }
    }
}
