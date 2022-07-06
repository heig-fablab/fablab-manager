<?php

namespace Tests;

use App\Models\File;
use App\Models\User;
use App\Models\Role;
use App\Models\Job;
use App\Models\Message;
use App\Constants\JobStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TestHelpers
{
    public static function generateRandomString(int $length = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function create_test_user(array $roles): User
    {
        $user = User::factory()->create();
        foreach ($roles as $role) {
            $user->roles()->attach(Role::where('name', $role)->first());
        }
        $user->save();
        return $user;
    }

    // Job methods
    public static function create_test_job(string $client_username = 'client.client'): Job
    {
        return Job::create([
            'title' => 'test',
            'description' => 'test',
            'job_category_id' => 1,
            'deadline' => '2022-09-20',
            'client_username' => $client_username,
        ]);
    }

    public static function create_assigned_test_job(
        string $client_username = 'client.client',
        string $worker_username = 'worker.worker',
        string $validator_username = 'validato.validato'
    ): Job {
        return Job::create([
            'title' => 'test',
            'description' => 'test',
            'deadline' => '2022-09-20',
            'status' => JobStatus::ASSIGNED,
            'job_category_id' => 1,
            'client_username' => $client_username,
            'worker_username' => $worker_username,
            'validator_username' => $validator_username,
        ]);
    }

    public static function create_completed_test_job(string $client_username = 'client.client'): Job
    {
        return Job::create([
            'title' => 'test',
            'description' => 'test',
            'deadline' => '2022-09-20',
            'working_hours' => 2,
            'status' => JobStatus::COMPLETED,
            'job_category_id' => 1,
            'client_username' => $client_username,
            'worker_username' => 'worker.worker',
            'validator_username' => 'validato.validato',
        ]);
    }

    // Message methods
    public static function create_test_message(
        string $sender_username = 'client.client',
        string $receiver_username = 'worker.worker',
        int $job_id = 1
    ): Message {
        return Message::create([
            'text' => 'test',
            'job_id' => $job_id,
            'sender_username' => $sender_username,
            'receiver_username' => $receiver_username,
        ]);
    }

    // File methods
    private static function get_test_file_path(object $file): string
    {
        $hash = hash_file(File::HASH_ALGORITHME, $file);
        $dir = substr($hash, 0, 2);
        return File::PRIVATE_FILE_STORAGE_PATH . $dir . '/' . $hash;
    }

    public static function create_test_file(
        string $name= 'document.pdf',
        string $mime_type = 'application/pdf',
        int $size = 100
    ): object {
        Storage::fake(File::PRIVATE_FILE_STORAGE_PATH);
        return UploadedFile::fake()->create(
            $name,
            $size,
            $mime_type
        );
    }

    public static function assert_file_present_in_storage(object $file): void
    {
        Storage::assertExists(self::get_test_file_path($file));
    }

    public static function assert_file_missing_in_storage(object $file): void
    {
        Storage::assertMissing(self::get_test_file_path($file));
    }
}
