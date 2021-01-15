<?php

namespace Tests\Feature;

use App\Models\Phase;
use App\Models\User;
use App\Models\WorkApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class WorkApplicationManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }


    /** @test */
    public function user_can_create_a_work_application()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user);

        $phase = Phase::factory()->create();

        $res = $this->postJson(route('api.applications.store'), [
            'name' => 'Developer',
            'company' => 'Facebook',
            'description' => 'Test Desc',
            'phase_id' => 1,
            'application_date' => '2020-01-06'
        ]);

        $lastApplication = WorkApplication::all()->first();

        $this->assertCount(1, WorkApplication::all());
        $this->assertEquals($phase->id, $lastApplication->phase_id);
        $this->assertEquals($this->user->id, $lastApplication->user_id);

        $res->assertCreated()->assertExactJson([
            'data' => [
                'id' => $lastApplication->id,
                'name' => $lastApplication->name,
                'company' => $lastApplication->company,
                'description' => $lastApplication->description,
                'phase_id' => $lastApplication->phase_id,
                'user_id' => $lastApplication->user_id,
                'application_date' => $lastApplication->application_date,
                'created_at' => $lastApplication->created_at,
                'updated_at' => $lastApplication->updated_at,
            ],
        ]);
    }

    /** @test */
    public function name_is_required_to_create_an_application()
    {
        $this->actingAs($this->user);

        $phase = Phase::factory()->create();

        $res = $this->postJson(route('api.applications.store'), [
            'name' => '',
            'company' => 'Facebook',
            'description' => 'Test Desc',
            'phase_id' => $phase->id,
            'application_date' => '2020-01-06'
        ]);

        $this->assertCount(0, WorkApplication::all());

        $res->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonValidationErrors('name');
    }

    /** @test */
    public function user_can_retrieve_a_work_application()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user);

        $application = WorkApplication::factory()->create(['user_id' => $this->user->id]);

        $res = $this->getJson(route('api.applications.show', ['application' => $application->id]));

        $res->assertOk()->assertExactJson([
            'data' => [
                'id' => $application->id,
                'name' => $application->name,
                'company' => $application->company,
                'description' => $application->description,
                'user_id' => $application->user_id,
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

    /** @test */
    public function only_the_owner_can_retrieve_his_work_application()
    {
        $this->actingAs($this->user);

        $anotherUser = User::factory()->create();
        $application = WorkApplication::factory()->create(['user_id' => $anotherUser->id]);

        $res = $this->getJson(route('api.applications.show', ['application' => $application->id]));

        $res->assertForbidden();
    }

    /** @test */
    public function user_can_update_a_work_application()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user);

        $application = WorkApplication::factory()->create(['user_id' => $this->user->id]);

        $res = $this->putJson(route('api.applications.update', ['application' => $application->id]), [
            'name' => 'Developer',
            'company' => 'Facebook',
            'phase_id' => 1,
            'description' => 'Test Desc',
            'application_date' => '2020-01-06'
        ]);

        $application = $application->fresh();

        $this->assertCount(1, WorkApplication::all());

        $res->assertOk()->assertJson([
            'data' => [
                'id' => $application->id,
                'name' => $application->name,
                'company' => $application->company,
                'description' => $application->description,
                'phase_id' => $application->phase_id,
                'user_id' => $application->user_id,
                'phase' => [
                    'id' => $application->phase->id,
                    'name' => $application->phase->name,
                    'display_name' => $application->phase->display_name,
                    'description' => $application->phase->description,
                ],
                'application_date' => $application->application_date,
            ],
        ]);
    }

    /** @test */
    public function only_the_owner_can_update_his_application()
    {
        $this->actingAs($this->user);

        $anotherUser = User::factory()->create();
        $application = WorkApplication::factory()->create(['user_id' => $anotherUser->id]);

        $res = $this->putJson(route('api.applications.update', ['application' => $application->id]), [
            'name' => 'Developer',
            'company' => 'Facebook',
            'phase_id' => 1,
            'description' => 'Test Desc',
            'application_date' => '2020-01-06'
        ]);

        $res->assertForbidden();
    }

    /** @test */
    public function user_can_delete_a_work_application()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user);

        $application = WorkApplication::factory()->create(['user_id' => $this->user->id]);

        $res = $this->deleteJson(route('api.applications.destroy', ['application' => $application->id]))
            ->assertNoContent();

        $this->assertCount(0, WorkApplication::all());
        $this->assertDeleted($application);
    }

    /** @test */
    public function only_the_owner_can_delete_his_work_application()
    {
        $this->actingAs($this->user);

        $anotherUser = User::factory()->create();
        $application = WorkApplication::factory()->create(['user_id' => $anotherUser->id]);

        $res = $this->deleteJson(route('api.applications.destroy', ['application' => $application->id]))
            ->assertForbidden();

        $this->assertCount(1, WorkApplication::all());
    }
}
