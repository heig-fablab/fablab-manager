<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobTest extends TestCase
{
    // Need to add seeding to CI before
    /*public function test_jobs_post_successfull()
    {
        $this->postJson('/api/jobs', [
            'title' => 'test',
            'id_category' => 1,
            'requestor_email' => 'requestor@heig-vd.ch',
            'worker_email' => 'worker@heig-vd.ch',
            'validator_email' => 'validator@heig-vd.ch',
            'description' => 'test',
            'deadline' => '2022-09-20'
        ])
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'title' => 'test',
                'id_category' => 1,
                'requestor_email' => 'requestor@heig-vd.ch',
                'worker_email' => 'worker@heig-vd.ch',
                'validator_email' => 'validator@heig-vd.ch',
                'description' => 'test',
                'deadline' => '2022-09-20'
            ]
        ]);
    }*/
}
