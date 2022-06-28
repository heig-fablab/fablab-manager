<?php

namespace Tests\Feature\Messages;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class UserStoreTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/messages';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_add_message_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_assigned_test_job($user->username);

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'text' => 'test',
                'job_id' => $job->id,
                'sender_username' => $user->username,
                'receiver_username' => 'worker.worker'
            ])
            ->assertStatus(403);
    }

    public function test_user_add_message_where_is_receiver_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'text' => 'test',
                'job_id' => $job->id,
                'sender_username' => 'worker.worker',
                'receiver_username' => $user->username
            ])
            ->assertStatus(403);
    }

    public function test_user_add_message_where_isnt_in_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job('client.client');

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'text' => 'test',
                'job_id' => $job->id,
                'sender_username' => $user->username,
                'receiver_username' => 'worker.worker'
            ])
            ->assertStatus(403);
    }

    public function test_user_add_message_where_worker_isnt_defined_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'text' => 'test',
                'job_id' => $job->id,
                'sender_username' => $user->username,
                'receiver_username' => 'worker.worker'
            ])
            ->assertStatus(400);
    }

    public function test_sender_add_message_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'text' => 'test',
                'job_id' => $job->id,
                'sender_username' => $user->username,
                'receiver_username' => 'worker.worker'
            ])
            ->assertStatus(201)
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

    public function test_admin_add_message_where_is_receiver_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job($user->username);

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'text' => 'test',
                'job_id' => $job->id,
                'sender_username' => 'client.client',
                'receiver_username' => $user->username
            ])
            ->assertStatus(201)
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

    public function test_admin_add_message_where_isnt_in_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job();

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'text' => 'test',
                'job_id' => $job->id,
                'sender_username' => $user->username,
                'receiver_username' => 'worker.worker'
            ])
            ->assertStatus(201)
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

    public function test_admin_add_message_where_isnt_in_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job();

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'text' => 'test',
                'job_id' => 1,
                'sender_username' => 'client.client',
                'receiver_username' => 'worker.worker'
            ])
            ->assertStatus(400);
    }
}
