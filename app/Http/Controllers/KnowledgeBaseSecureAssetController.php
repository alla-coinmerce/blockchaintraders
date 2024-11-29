<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class KnowledgeBaseSecureAssetController extends Controller
{
    public function index()
    {
        return view('admin.knowledge-base.asset.index');
    }

    public function download(string $filename)
    {
        $storagePath = storage_path('app/knowledge-base-assets/downloads/'.$filename);

        if(!File::exists($storagePath))
        {
            abort(404);
        }

        $mimeType = mime_content_type($storagePath);

        $headers = array(
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        );

        return Response::make(file_get_contents($storagePath), 200, $headers);
    }

    public function image(string $filename)
    {
        $storagePath = storage_path('app/knowledge-base-assets/images/'.$filename);

        if(!File::exists($storagePath))
        {
            abort(404);
        }

        $mimeType = mime_content_type($storagePath);

        $headers = array(
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        );

        return Response::make(file_get_contents($storagePath), 200, $headers);
    }

    public function video(string $filename)
    {
        $storagePath = storage_path('app/knowledge-base-assets/videos/'.$filename);

        if(!File::exists($storagePath))
        {
            abort(404);
        }

        $mimeType = mime_content_type($storagePath);

        return response()->file($storagePath);
    }
}