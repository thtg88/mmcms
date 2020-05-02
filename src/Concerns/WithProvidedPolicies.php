<?php

namespace Thtg88\MmCms\Concerns;

use Illuminate\Support\Facades\Gate;
use Thtg88\MmCms\Models\ContentField;
use Thtg88\MmCms\Models\ContentMigrationMethod;
use Thtg88\MmCms\Models\ContentModel;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Models\ImageCategory;
use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Models\SeoEntry;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Policies\ContentFieldPolicy;
use Thtg88\MmCms\Policies\ContentMigrationMethodPolicy;
use Thtg88\MmCms\Policies\ContentModelPolicy;
use Thtg88\MmCms\Policies\ContentTypePolicy;
use Thtg88\MmCms\Policies\ImageCategoryPolicy;
use Thtg88\MmCms\Policies\RolePolicy;
use Thtg88\MmCms\Policies\SeoEntryPolicy;
use Thtg88\MmCms\Policies\UserPolicy;

trait WithProvidedPolicies
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ContentField::class => ContentFieldPolicy::class,
        ContentMigrationMethod::class => ContentMigrationMethodPolicy::class,
        ContentModel::class => ContentModelPolicy::class,
        ContentType::class => ContentTypePolicy::class,
        ImageCategory::class => ImageCategoryPolicy::class,
        Role::class => RolePolicy::class,
        SeoEntry::class => SeoEntryPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function bootPolicies(): void
    {
        foreach ($this->policies() as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies(): array
    {
        return $this->policies;
    }
}
