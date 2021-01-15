<?php

namespace Tests\Feature;

use App\Models\Phase;
use App\Models\User;
use App\Models\WorkApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class WorkApplicationChangePhaseTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_change_the_work_application_phase()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user);

        $phase = Phase::factory()->create();
        $anotherPhase = Phase::factory()->create();

        $application = WorkApplication::factory()->create([
            'user_id' => $this->user->id,
            'phase_id' => $phase->id,
        ]);

        $res = $this->patchJson(route('api.phase.applications.change', ['application' => $application->id]), [
            'phase_id' => $anotherPhase->id,
        ]);

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

    /** @test */
    public function only_the_owner_can_change_his_work_application_phase()
    {
        $this->actingAs($this->user);

        $phase = Phase::factory()->create();
        $anotherPhase = Phase::factory()->create();

        $anotherUser = User::factory()->create();
        $application = WorkApplication::factory()->create([
            'user_id' => $anotherUser->id,
            'phase_id' => $phase->id,
        ]);

        $res = $this->patchJson(route('api.phase.applications.change', ['application' => $application->id]), [
            'phase_id' => $anotherPhase->id,
        ])->assertForbidden();
    }

    /** @test */
    public function user_can_change_a_phase_to_another_valid_phase()
    {
        $this->actingAs($this->user);

        $phase = Phase::factory()->create();

        // Another Phase
        Phase::factory()->create();
        $fakeIDPhase = 5;

        $application = WorkApplication::factory()->create([
            'user_id' => $this->user->id,
            'phase_id' => $phase->id,
        ]);

        $res = $this->patchJson(route('api.phase.applications.change', ['application' => $application->id]), [
            'phase_id' => $fakeIDPhase,
        ]);

        $res->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('phase_id');
    }
}
