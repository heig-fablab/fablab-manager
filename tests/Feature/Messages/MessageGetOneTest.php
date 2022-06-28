<?php

namespace Tests\Feature\Messages;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class MessageGetOneTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/messages/';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_get_job_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_test_job($user->username);
        $message = TestHelpers::create_test_message($user->username, 'worker.worker', $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $message->id)
            ->assertStatus(403);
    }

    public function test_user_get_message_not_participate_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $message = TestHelpers::create_test_message();

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $message->id)
            ->assertStatus(403);
    }

    public function test_sender_get_message_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);
        $message = TestHelpers::create_test_message($user->username, 'worker.worker', $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $message->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'text' => 'test',
                    'sender_username' => $user->username,
                    'receiver_username' => 'worker.worker',
                    'job' => [
                        "id" => $job->id,
                        "title" => $job->title,
                    ]
                ]
            ]);
    }

    public function test_receiver_get_message_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);
        $message = TestHelpers::create_test_message('client.client', $user->username, $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $message->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'text' => 'test',
                    'sender_username' => 'client.client',
                    'receiver_username' => $user->username,
                    'job' => [
                        "id" => $job->id,
                        "title" => $job->title,
                    ]
                ]
            ]);
    }

    public function test_admin_get_job_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job('client.client');
        $message = TestHelpers::create_test_message('client.client', 'worker.worker', $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $message->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'text' => 'test',
                    'sender_username' => 'client.client',
                    'receiver_username' => 'worker.worker',
                    'job' => [
                        "id" => $job->id,
                        "title" => $job->title,
                    ]
                ]
            ]);
    }
}
