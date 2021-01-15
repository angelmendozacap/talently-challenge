<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\WorkApplication;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkApplicationRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\WorkApplication as WorkApplicationResource;
use App\Http\Resources\WorkApplicationCollection;

class WorkApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = request()->user()->applications->load('phase');
        return new WorkApplicationCollection($applications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkApplicationRequest $request)
    {
        $application = $request->user()->applications()->create($request->all());

        return (new WorkApplicationResource($application))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkApplication  $workApplication
     * @return \Illuminate\Http\Response
     */
    public function show(WorkApplication $application)
    {
        $this->authorize('view', $application);

        $application->load('phase');
        return new WorkApplicationResource($application);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkApplication  $workApplication
     * @return \Illuminate\Http\Response
     */
    public function update(WorkApplicationRequest $request, WorkApplication $application)
    {
        $this->authorize('update', $application);

        $application->update($request->all());

        $application->load('phase');

        return new WorkApplicationResource($application);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkApplication  $workApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkApplication $application)
    {
        $this->authorize('delete', $application);

        $application->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
