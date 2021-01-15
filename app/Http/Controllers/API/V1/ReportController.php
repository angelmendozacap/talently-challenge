<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function index()
    {
        $filesPath = collect(Storage::disk('public')->files("applications-reports"));
        $paths = $filesPath->map(function ($path, $key) {
            return ["file_path" => url('storage/' . $path)];
        });

        return response()->json($paths, Response::HTTP_OK);
    }
}
