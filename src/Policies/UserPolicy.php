<?php

namespace Thtg88\MmCms\Policies;

use Illuminate\Support\Facades\Config;

class UserPolicy extends Policy
{
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
