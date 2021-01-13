<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkApplication as WorkApplicationResource;
use App\Models\WorkApplication;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
    public function store(Request $request)
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
    public function update(Request $request, WorkApplication $workApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkApplication  $workApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkApplication $workApplication)
    {
        //
    }
}
