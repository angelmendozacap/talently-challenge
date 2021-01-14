<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\WorkApplication;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkApplication as WorkApplicationResource;

class PhaseWorkApplicationController extends Controller
{
    public function change(Request $request, WorkApplication $application)
    {
        $application->update($request->all());

        $application->load('phase');

        return new WorkApplicationResource($application);
    }
}
