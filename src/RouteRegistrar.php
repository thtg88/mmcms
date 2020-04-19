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
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for the package.
     *
     * @return void
     */
    public function all()
    {
        $this->router->group(['as' => 'mmcms.'], function ($router) {
            $this->forAuth($router);
            $this->forContentFields($router);
            $this->forContentMigrationMethods($router);
            $this->forContentModels($router);
            $this->forContentTypes($router);
            $this->forContentValidationRuleAdditionalFieldTypes($router);
            $this->forImageCategories($router);
            $this->forImages($router);
            $this->forRoles($router);
            $this->forSeoEntries($router);
            $this->forUsers($router);
        });
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forAuth($router): void
    {
        $router->group(
            ['as' => 'auth.', 'prefix' => 'auth'],
            static function ($router) {
                $router->post('register', [
                    'uses' => 'AuthController@register',
                    'as' => 'register',
                ]);
                $router->post('login', [
                    'uses' => 'AuthController@login',
                    'as' => 'login',
                ]);
                $router->post('token', [
                    'uses' => 'AuthController@token',
                    'as' => 'token',
                ]);

                $router->group(
                    ['middleware' => 'auth:api'],
                    static function ($router) {
                        $router->delete('logout', [
                            'uses' => 'AuthController@logout',
                            'as' => 'logout',
                        ]);
                        $router->get('me', [
                            'uses' => 'AuthController@me',
                            'as' => 'me',
                        ]);
                        $router->put('me', [
                            'uses' => 'AuthController@updateProfile',
                            'as' => 'update-profile',
                        ]);
                    }
                );
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forContentFields($router): void
    {
        $router->group(
            [
                'as' => 'content-fields.',
                'middleware' => ['auth:api', 'authorize.developer'],
                'prefix' => 'content-fields',
            ],
            static function ($router) {
                $router->get('paginate', [
                    'uses' => 'ContentFieldController@paginate',
                    'as' => 'paginate',
                ]);
                $router->get('{id}', [
                    'uses' => 'ContentFieldController@show',
                    'as' => 'show',
                ]);
                // TODO: missing Request class
                $router->put('{id}', [
                    'uses' => 'ContentFieldController@update',
                    'as' => 'update',
                ]);
                $router->delete('{id}', [
                    'uses' => 'ContentFieldController@destroy',
                    'as' => 'destroy',
                ]);
                $router->get('/', [
                    'uses' => 'ContentFieldController@index',
                    'as' => 'index',
                ]);
                $router->post('/', [
                    'uses' => 'ContentFieldController@store',
                    'as' => 'store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forContentMigrationMethods($router): void
    {
        $router->group(
            [
                'as' => 'content-migration-methods.',
                'prefix' => 'content-migration-methods',
                'middleware' => ['auth:api'],
            ],
            static function ($router) {
                $router->post('{id}/restore', [
                    'uses' => 'ContentMigrationMethodController@restore',
                    'as' => 'restore',
                ]);
                $router->get('paginate', [
                    'uses' => 'ContentMigrationMethodController@paginate',
                    'as' => 'paginate',
                ]);
                $router->get('{id}', [
                    'uses' => 'ContentMigrationMethodController@show',
                    'as' => 'show',
                ]);
                $router->put('{id}', [
                    'uses' => 'ContentMigrationMethodController@update',
                    'as' => 'update',
                ]);
                $router->delete('{id}', [
                    'uses' => 'ContentMigrationMethodController@destroy',
                    'as' => 'destroy',
                ]);
                $router->get('/', [
                    'uses' => 'ContentMigrationMethodController@index',
                    'as' => 'index',
                ]);
                $router->post('/', [
                    'uses' => 'ContentMigrationMethodController@store',
                    'as' => 'store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forContentModels($router): void
    {
        $router->group(
            [
                'as' => 'content-models.',
                'middleware' => ['auth:api', 'authorize.developer'],
                'prefix' => 'content-models',
            ],
            static function ($router) {
                $router->get('paginate', [
                    'uses' => 'ContentModelController@paginate',
                    'as' => 'paginate',
                ]);
                $router->get('{id}', [
                    'uses' => 'ContentModelController@show',
                    'as' => 'show',
                ]);
                $router->put('{id}', [
                    'uses' => 'ContentModelController@update',
                    'as' => 'update',
                ]);
                $router->delete('{id}', [
                    'uses' => 'ContentModelController@destroy',
                    'as' => 'destroy',
                ]);
                $router->get('/', [
                    'uses' => 'ContentModelController@index',
                    'as' => 'index',
                ]);
                $router->post('/', [
                    'uses' => 'ContentModelController@store',
                    'as' => 'store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forContentTypes($router): void
    {
        $router->group(
            [
                'as' => 'content-types.',
                'middleware' => ['auth:api', 'authorize.developer'],
                'prefix' => 'content-types',
            ],
            static function ($router) {
                $router->get('paginate', [
                    'uses' => 'ContentTypeController@paginate',
                    'as' => 'paginate',
                ]);
                $router->get('{id}', [
                    'uses' => 'ContentTypeController@show',
                    'as' => 'show',
                ]);
                $router->put('{id}', [
                    'uses' => 'ContentTypeController@update',
                    'as' => 'update',
                ]);
                $router->delete('{id}', [
                    'uses' => 'ContentTypeController@destroy',
                    'as' => 'destroy',
                ]);
                $router->get('/', [
                    'uses' => 'ContentTypeController@index',
                    'as' => 'index',
                ]);
                $router->post('/', [
                    'uses' => 'ContentTypeController@store',
                    'as' => 'store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forContentValidationRuleAdditionalFieldTypes($router): void
    {
        $router->group(
            [
                'as' => 'mmcms.content-validation-rule-additional-field-types.',
                'prefix' => 'mmcms.content-validation-rule-additional-field-types',
                'middleware' => ['auth:api', 'authorize.developer'],
            ],
            static function ($router) {
                $router->get('paginate', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@paginate',
                    'as' => 'paginate',
                ]);
                $router->get('{id}', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@show',
                    'as' => 'show',
                ]);
                $router->put('{id}', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@update',
                    'as' => 'update',
                ]);
                $router->delete('{id}', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@destroy',
                    'as' => 'destroy',
                ]);
                $router->get('/', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@index',
                    'as' => 'index',
                ]);
                $router->post('/', [
                    'uses' => 'ContentValidationRuleAdditionalFieldTypeController@store',
                    'as' => 'store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forImageCategories($router): void
    {
        $router->group(
            [
                'as' => 'image-categories.',
                'middleware' => ['auth:api'],
                'prefix' => 'image-categories',
            ],
            static function ($router) {
                $router->post('{id}/restore', [
                    'uses' => 'ImageCategoryController@restore',
                    'as' => 'restore',
                ]);
                $router->get('paginate', [
                    'uses' => 'ImageCategoryController@paginate',
                    'as' => 'paginate',
                ]);
                $router->delete('{id}', [
                    'uses' => 'ImageCategoryController@destroy',
                    'as' => 'destroy',
                ]);
                $router->get('{id}', [
                    'uses' => 'ImageCategoryController@show',
                    'as' => 'show',
                ]);
                $router->put('{id}', [
                    'uses' => 'ImageCategoryController@update',
                    'as' => 'update',
                ]);
                $router->get('/', [
                    'uses' => 'ImageCategoryController@index',
                    'as' => 'index',
                ]);
                $router->post('/', [
                    'uses' => 'ImageCategoryController@store',
                    'as' => 'store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forImages($router): void
    {
        $router->group(
            [
                'as' => 'images.',
                'middleware' => ['auth:api'],
                'prefix' => 'images',
            ],
            static function ($router) {
                // $router->get('paginate', [
                //     'as' => 'paginate',
                //     'middleware' => 'authorize.administrator',
                //     'uses' => 'ImageController@paginate',
                // ]);
                $router->delete('{id}', [
                    'as' => 'destroy',
                    'middleware' => 'authorize.administrator',
                    'uses' => 'ImageController@destroy',
                ]);
                $router->get('{id}', [
                    'as' => 'show',
                    'uses' => 'ImageController@show',
                ]);
                $router->put('{id}', [
                    'as' => 'update',
                    'middleware' => 'authorize.administrator',
                    'uses' => 'ImageController@update',
                ]);
                // $router->get('/', [
                //     'as' => 'index',
                //     'middleware' => 'authorize.administrator',
                //     'uses' => 'ImageController@index',
                // ]);
                $router->post('/', [
                    'as' => 'store',
                    'middleware' => 'authorize.administrator',
                    'uses' => 'ImageController@store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forRoles($router): void
    {
        $router->group(
            [
                'as' => 'roles.',
                'middleware' => 'auth:api',
                'prefix' => 'roles',
            ],
            static function ($router) {
                $router->post('{id}/restore', [
                    'uses' => 'RoleController@restore',
                    'as' => 'restore',
                ]);
                $router->get('paginate', [
                    'uses' => 'RoleController@paginate',
                    'as' => 'paginate',
                ]);
                $router->get('{id}', [
                    'uses' => 'RoleController@show',
                    'as' => 'show',
                ]);
                $router->put('{id}', [
                    'uses' => 'RoleController@update',
                    'as' => 'update',
                ]);
                $router->delete('{id}', [
                    'uses' => 'RoleController@destroy',
                    'as' => 'destroy',
                ]);
                $router->get('/', [
                    'uses' => 'RoleController@index',
                    'as' => 'index',
                ]);
                $router->post('/', [
                    'uses' => 'RoleController@store',
                    'as' => 'store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forSeoEntries($router): void
    {
        $router->group(
            [
                'as' => 'seo-entries.',
                'middleware' => ['auth:api'],
                'prefix' => 'seo-entries',
            ],
            static function ($router) {
                $router->post('{id}/restore', [
                    'as' => 'restore',
                    'uses' => 'SeoEntryController@restore',
                ]);
                $router->get('paginate', [
                    'as' => 'paginate',
                    'uses' => 'SeoEntryController@paginate',
                ]);
                $router->delete('{id}', [
                    'as' => 'destroy',
                    'uses' => 'SeoEntryController@destroy',
                ]);
                $router->get('{id}', [
                    'as' => 'show',
                    'uses' => 'SeoEntryController@show',
                ]);
                $router->put('{id}', [
                    'as' => 'update',
                    'uses' => 'SeoEntryController@update',
                ]);
                $router->get('/', [
                    'as' => 'index',
                    'uses' => 'SeoEntryController@index',
                ]);
                $router->post('/', [
                    'as' => 'store',
                    'uses' => 'SeoEntryController@store',
                ]);
            }
        );
    }

    /**
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @return void
     */
    public function forUsers($router): void
    {
        $router->group(
            [
                'as' => 'users.',
                'middleware' => 'auth:api',
                'prefix' => 'users',
            ],
            static function ($router) {
                $router->post('{id}/restore', [
                    'uses' => 'UserController@restore',
                    'as' => 'restore',
                ]);
                $router->get('paginate', [
                    'as' => 'paginate',
                    'uses' => 'UserController@paginate',
                ]);
                $router->get('{id}', [
                    'as' => 'show',
                    'uses' => 'UserController@show',
                ]);
                $router->put('{id}', [
                    'as' => 'update',
                    'uses' => 'UserController@update',
                ]);
                $router->delete('{id}', [
                    'as' => 'destroy',
                    'uses' => 'UserController@destroy',
                ]);
                $router->get('/', [
                    'as' => 'index',
                    'uses' => 'UserController@index',
                ]);
                $router->post('/', [
                    'as' => 'store',
                    'uses' => 'UserController@store',
                ]);
            }
        );
    }
}
