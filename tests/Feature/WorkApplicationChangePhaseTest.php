<?php

namespace Tests\Feature;

use App\Models\Phase;
use App\Models\WorkApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkApplicationChangePhaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_change_the_work_application_phase()
    {
        $this->withoutExceptionHandling();

        $phase = Phase::factory()->create();
        $anotherPhase = Phase::factory()->create();

        $application = WorkApplication::factory()->create(['phase_id' => $phase->id]);

        $res = $this->patchJson(route('api.phase.applications.change', ['application' => $application->id]), [
            'phase_id' => $anotherPhase->id,
        ])->assertOk();

        $application = $application->fresh();

        $this->assertCount(2, Phase::all());
        $this->assertEquals($anotherPhase->id, $application->phase_id);

        $res->assertOk()->assertJson([
            'data' => [
                'id' => $application->id,
                'phase_id' => $anotherPhase->id,
                'phase' => [
                    'id' => $anotherPhase->id,
                ],
                'application_date' => $application->application_date,
            ],
        ]);
    }
}
