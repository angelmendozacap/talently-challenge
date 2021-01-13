<?php

namespace Tests\Feature;

use App\Models\Phase;
use App\Models\WorkApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkApplicationManagementTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function user_can_create_a_work_application()
    {
        $this->withoutExceptionHandling();

        $phase = Phase::factory()->create();

        $res = $this->postJson(route('api.applications.store'), [
            'name' => 'Developer',
            'company' => 'Facebook',
            'description' => 'Test Desc',
            'phase_id' => 1,
            'application_date' => '2020-01-06'
        ]);

        $lastApplication = WorkApplication::all()->first();

        $this->assertEquals($phase->id, $lastApplication->phase_id);

        $res->assertCreated()->assertExactJson([
            'data' => [
                'id' => $lastApplication->id,
                'name' => $lastApplication->name,
                'company' => $lastApplication->company,
                'description' => $lastApplication->description,
                'phase_id' => $lastApplication->phase_id,
                'application_date' => $lastApplication->application_date,
                'created_at' => $lastApplication->created_at,
                'updated_at' => $lastApplication->updated_at,
            ],
        ]);
    }

    /** @test */
    public function user_can_retrieve_a_work_application()
    {
        $this->withoutExceptionHandling();

        $application = WorkApplication::factory()->create();

        $res = $this->getJson(route('api.applications.show', ['application' => $application->id]));
        // dd($res->getContent());

        $res->assertOk()->assertExactJson([
            'data' => [
                'id' => $application->id,
                'name' => $application->name,
                'company' => $application->company,
                'description' => $application->description,
                'phase_id' => $application->phase_id,
                'phase' => [
                    'id' => $application->phase->id,
                    'name' => $application->phase->name,
                    'display_name' => $application->phase->display_name,
                    'description' => $application->phase->description,
                    'created_at' => $application->phase->created_at,
                    'updated_at' => $application->phase->updated_at,
                ],
                'application_date' => $application->application_date,
                'created_at' => $application->created_at,
                'updated_at' => $application->updated_at,
            ],
        ]);
    }
}
