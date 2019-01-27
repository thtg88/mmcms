<?php

namespace Thtg88\MmCms;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forAuth();
        $this->forContentFields();
        $this->forContentMigrationMethods();
        $this->forContentModels();
        $this->forContentTypes();
        $this->forContentValidationRuleAdditionalFieldTypes();
        $this->forRoles();
        $this->forUsers();
    }

    public function forAuth()
    {
        // Auth routes...
        $this->router->post('auth/register', [
            'uses' => 'AuthController@register',
            'as' => 'register'
        ]);
        $this->router->post('auth/login', [
            'uses' => 'AuthController@login',
            'as' => 'login'
        ]);
        $this->router->post('auth/token', [
            'uses' => 'AuthController@token',
            'as' => 'token'
        ]);

        $this->router->group(['middleware' => 'auth:api'], function($router) {
            $router->delete('auth/logout', [
                'uses' => 'AuthController@logout',
                'as' => 'logout'
            ]);
            $router->get('auth/me', [
                'uses' => 'AuthController@me',
                'as' => 'me'
            ]);
            $router->put('auth/me', [
                'uses' => 'AuthController@updateProfile',
                'as' => 'update-profile'
            ]);
        });
    }

    public function forContentFields()
    {
        $this->router->group(['as' => 'mmcms.content-fields.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // Role routes...
                $router->get('content-fields', [
                    'uses' => 'ContentFieldController@index',
                    'as' => 'index'
                ]);
                $router->get('content-fields/paginate', [
                    'uses' => 'ContentFieldController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('content-fields/{id}', [
                    'uses' => 'ContentFieldController@show',
                    'as' => 'show'
                ]);
                $router->post('content-fields', [
                    'uses' => 'ContentFieldController@store',
                    'as' => 'store'
                ]);
                $router->put('content-fields/{id}', [
                    'uses' => 'ContentFieldController@update',
                    'as' => 'update'
                ]);
                $router->delete('content-fields/{id}', [
                    'uses' => 'ContentFieldController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }

    public function forContentMigrationMethods()
    {
        $this->router->group(['as' => 'mmcms.content-migration-methods.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // Role routes...
                $router->get('content-migration-methods', [
                    'uses' => 'ContentMigrationMethodController@index',
                    'as' => 'index'
                ]);
                $router->get('content-migration-methods/paginate', [
                    'uses' => 'ContentMigrationMethodController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('content-migration-methods/{id}', [
                    'uses' => 'ContentMigrationMethodController@show',
                    'as' => 'show'
                ]);
                $router->post('content-migration-methods', [
                    'uses' => 'ContentMigrationMethodController@store',
                    'as' => 'store'
                ]);
                $router->put('content-migration-methods/{id}', [
                    'uses' => 'ContentMigrationMethodController@update',
                    'as' => 'update'
                ]);
                $router->delete('content-migration-methods/{id}', [
                    'uses' => 'ContentMigrationMethodController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }

    public function forContentModels()
    {
        $this->router->group(['as' => 'mmcms.content-models.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // Role routes...
                $router->get('content-models', [
                    'uses' => 'ContentModelController@index',
                    'as' => 'index'
                ]);
                $router->get('content-models/paginate', [
                    'uses' => 'ContentModelController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('content-models/{id}', [
                    'uses' => 'ContentModelController@show',
                    'as' => 'show'
                ]);
                $router->post('content-models', [
                    'uses' => 'ContentModelController@store',
                    'as' => 'store'
                ]);
                $router->put('content-models/{id}', [
                    'uses' => 'ContentModelController@update',
                    'as' => 'update'
                ]);
                $router->delete('content-models/{id}', [
                    'uses' => 'ContentModelController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }

    public function forContentTypes()
    {
        $this->router->group(['as' => 'mmcms.content-types.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // Role routes...
                $router->get('content-types', [
                    'uses' => 'ContentTypeController@index',
                    'as' => 'index'
                ]);
                $router->get('content-types/paginate', [
                    'uses' => 'ContentTypeController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('content-types/{id}', [
                    'uses' => 'ContentTypeController@show',
                    'as' => 'show'
                ]);
                $router->post('content-types', [
                    'uses' => 'ContentTypeController@store',
                    'as' => 'store'
                ]);
                $router->put('content-types/{id}', [
                    'uses' => 'ContentTypeController@update',
                    'as' => 'update'
                ]);
                $router->delete('content-types/{id}', [
                    'uses' => 'ContentTypeController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }

    public function forContentValidationRuleAdditionalFieldTypes()
    {
        $this->router->group(['as' => 'mmcms.content-validation-rule-additional-field-types.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // Role routes...
                $router->get('content-validation-rule-additional-field-types', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@index',
                    'as' => 'index'
                ]);
                $router->get('content-validation-rule-additional-field-types/paginate', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('content-validation-rule-additional-field-types/{id}', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@show',
                    'as' => 'show'
                ]);
                $router->post('content-validation-rule-additional-field-types', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@store',
                    'as' => 'store'
                ]);
                $router->put('content-validation-rule-additional-field-types/{id}', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@update',
                    'as' => 'update'
                ]);
                $router->delete('content-validation-rule-additional-field-types/{id}', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }

    public function forRoles()
    {
        $this->router->group(['as' => 'mmcms.roles.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // Role routes...
                $router->get('roles', [
                    'uses' => 'RoleController@index',
                    'as' => 'index'
                ]);
                $router->get('roles/paginate', [
                    'uses' => 'RoleController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('roles/{id}', [
                    'uses' => 'RoleController@show',
                    'as' => 'show'
                ]);
                $router->post('roles', [
                    'uses' => 'RoleController@store',
                    'as' => 'store'
                ]);
                $router->put('roles/{id}', [
                    'uses' => 'RoleController@update',
                    'as' => 'update'
                ]);
                $router->delete('roles/{id}', [
                    'uses' => 'RoleController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }

    public function forUsers()
    {
        $this->router->group(['as' => 'mmcms.users.'], function($router) {

            $router->group(['middleware' => 'auth:api'], function($router) {

                // User routes...
                $router->get('users', [
                    'uses' => 'UserController@index',
                    'as' => 'index'
                ]);
                $router->get('users/paginate', [
                    'uses' => 'UserController@paginate',
                    'as' => 'paginate'
                ]);
                $router->get('users/{id}', [
                    'uses' => 'UserController@show',
                    'as' => 'show'
                ]);
                $router->post('users', [
                    'uses' => 'UserController@store',
                    'as' => 'store'
                ]);
                $router->put('users/{id}', [
                    'uses' => 'UserController@update',
                    'as' => 'update'
                ]);
                $router->delete('users/{id}', [
                    'uses' => 'UserController@destroy',
                    'as' => 'destroy'
                ]);
            });
        });
    }
}
