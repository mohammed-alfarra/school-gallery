<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\CreateSchoolRequest;
use App\Http\Requests\School\UpdateSchoolRequest;
use App\Http\Resources\School\SchoolResource;
use App\Models\School;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SchoolController extends Controller
{
    public function __construct(private ImageUploadService $imageUploadService)
    {
        $this->middleware(['auth:admins']);
    }

    public function index(): AnonymousResourceCollection
    {
        $schools = School::with('images.thumbnails')->get();

        return SchoolResource::collection($schools);
    }

    public function show(School $school): JsonResponse
    {
        return $this->responseSuccess(
            null,
            new SchoolResource($school->load('images.thumbnails'))
        );
    }

    public function store(CreateSchoolRequest $request): JsonResponse
    {
        $school = School::create($request->validated());

        return $this->responseCreated(null, new SchoolResource($school));
    }

    public function update(UpdateSchoolRequest $request, School $school): JsonResponse
    {
        $school->update($request->validated());

        return $this->responseSuccess(null, new SchoolResource($school));
    }

    public function destroy(School $school): JsonResponse
    {
        $school->delete();

        return $this->responseDeleted();
    }
}
