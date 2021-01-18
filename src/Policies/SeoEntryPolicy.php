<?php

namespace Thtg88\MmCms\Policies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Thtg88\MmCms\Models\User;

class SeoEntryPolicy extends Policy
{
    /**
     * Determine whether the user can view the model.
     *
     * @param \Thtg88\MmCms\Models\User           $user
     * @param \Illuminate\Eloquent\Database\Model $model
     *
     * @return bool
     */
    public function view(User $user, Model $model)
    {
        return true;
    }

    /**
     * Get the default authorized role for the policy.
     *
     * @return string
     */
    public function getDefaultAuthorizationRole(): string
    {
        return Config::get('mmcms.roles.names.administrator');
    }
}
