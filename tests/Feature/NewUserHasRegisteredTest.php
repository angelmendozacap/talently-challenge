<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Events\NewUserHasRegisteredEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewUserHasRegisteredTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_email_must_be_sended()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $this->postJson('/api/v1/register', $this->data())->assertCreated();

        $lastUser = User::all()->first();

        Mail::assertSent(WelcomeNewUserMail::class, function ($mail) use ($lastUser) {
            return $mail->user->id === $lastUser->id &&
                $mail->hasTo($lastUser->email);
        });
    }

    /** @test */
    public function an_event_must_be_dispached()
    {
        $this->withoutExceptionHandling();

        Event::fake();

        $this->postJson('/api/v1/register', $this->data())->assertCreated();

        Event::assertDispatched(NewUserHasRegisteredEvent::class);
    }

    private function data()
    {
        return [
            "email" => "user@talently.com",
	        "name" => "User Name",
	        "password" => "talently",
	        "password_confirmation" => "talently",
        ];
    }
}
