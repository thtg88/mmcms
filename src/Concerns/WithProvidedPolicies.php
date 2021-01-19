<?php

namespace Thtg88\MmCms\Concerns;

use Illuminate\Support\Facades\Gate;
use Thtg88\MmCms\Models\ContentField;
use Thtg88\MmCms\Models\ContentFieldContentValidationRule;
use Thtg88\MmCms\Models\ContentMigrationMethod;
use Thtg88\MmCms\Models\ContentModel;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Models\ContentTypeContentValidationRule;
use Thtg88\MmCms\Models\ContentValidationRule;
use Thtg88\MmCms\Models\ImageCategory;
use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Models\SeoEntry;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Policies\ContentFieldContentValidationRulePolicy;
use Thtg88\MmCms\Policies\ContentFieldPolicy;
use Thtg88\MmCms\Policies\ContentMigrationMethodPolicy;
use Thtg88\MmCms\Policies\ContentModelPolicy;
use Thtg88\MmCms\Policies\ContentTypeContentValidationRulePolicy;
use Thtg88\MmCms\Policies\ContentTypePolicy;
use Thtg88\MmCms\Policies\ContentValidationRulePolicy;
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
        ContentFieldContentValidationRule::class => ContentFieldContentValidationRulePolicy::class,
        ContentField::class                      => ContentFieldPolicy::class,
        ContentMigrationMethod::class            => ContentMigrationMethodPolicy::class,
        ContentModel::class                      => ContentModelPolicy::class,
        ContentType::class                       => ContentTypePolicy::class,
        ContentTypeContentValidationRule::class  => ContentTypeContentValidationRulePolicy::class,
        ContentValidationRule::class             => ContentValidationRulePolicy::class,
        ImageCategory::class                     => ImageCategoryPolicy::class,
        Role::class                              => RolePolicy::class,
        SeoEntry::class                          => SeoEntryPolicy::class,
        User::class                              => UserPolicy::class,
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
