<?php

namespace App\Http\Controllers\API;

use App\Models\WorkApplication;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeApplicationPhaseRequest;
use App\Http\Resources\WorkApplication as WorkApplicationResource;

class PhaseWorkApplicationController extends Controller
{
    public function change(ChangeApplicationPhaseRequest $request, WorkApplication $application)
    {
        $this->authorize('update', $application);

        $application->update($request->all());

        $application->load('phase');

        return new WorkApplicationResource($application);
    }
}
