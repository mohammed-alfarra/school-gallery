<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\UploadImagesRequest;
use App\Models\School;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function __construct(private ImageUploadService $imageUploadService)
    {
        $this->middleware(['auth:admins']);
    }

    public function store(UploadImagesRequest $request, School $school): JsonResponse
    {
        $this->imageUploadService
            ->setModel($school)
            ->execute($request->file('images'));

        return $this->responseCreated();
    }
}
