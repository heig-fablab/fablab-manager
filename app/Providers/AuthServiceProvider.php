<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\File;
use App\Models\JobCategory;
use App\Models\FileType;
use App\Models\Job;
use App\Models\Message;
use App\Models\User;
use App\Policies\FilePolicy;
use App\Policies\FileTypePolicy;
use App\Policies\JobCategoryPolicy;
use App\Policies\JobPolicy;
use App\Policies\MessagePolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        File::class => FilePolicy::class,
        FileType::class => FileTypePolicy::class,
        JobCategory::class => JobCategoryPolicy::class,
        Job::class => JobPolicy::class,
        Message::class => MessagePolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
