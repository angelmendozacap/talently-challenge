<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\WorkApplication;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkApplicationRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\WorkApplication as WorkApplicationResource;

class WorkApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkApplicationRequest $request)
    {
        $application = WorkApplication::create($request->all());

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
        $application->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
