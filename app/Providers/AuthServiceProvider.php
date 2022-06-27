<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;
use App\Models\File;
use App\Models\JobCategory;
use App\Policies\DevicePolicy;
use App\Policies\FilePolicy;
use App\Policies\FileTypePolicy;
use App\Policies\JobCategoryPolicy;
use App\Policies\JobPolicy;
use App\Policies\MessagePolicy;
use App\Policies\UserPolicy;

use function Ramsey\Uuid\v1;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Device::class => DevicePolicy::class,
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
