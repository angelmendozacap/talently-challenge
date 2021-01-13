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

        $this->postJson(route('api.applications.store'), [
            'name' => 'Developer',
            'company' => 'Facebook',
            'description' => 'Test Desc',
            'phase_id' => 1,
            'application_date' => '2020-01-06'
        ])->assertCreated();

        $lastApplication = WorkApplication::all()->first();

        $this->assertEquals($phase->id, $lastApplication->phase_id);
    }
}