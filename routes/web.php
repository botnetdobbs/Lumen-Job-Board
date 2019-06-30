<?php
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function() use(&$router) {
    /**
     * Authentication
     */
    $router->group(['prefix' => 'auth'], function() use(&$router) {
        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
    });


    $router->group(['prefix' => 'jobs', 'middleware' => ['auth:api', 'cors']], function() use(&$router) {
        /**
         * Jobs open
         */
        $router->get('/', 'JobsController@index');
        $router->get('/{id}', 'JobsController@show');

        /**
         * Jobs employers only access
         */
        $router->group(['middleware' => 'role:employer'], function() use(&$router) {
            $router->post('/', 'JobsController@store');
            $router->put('/{id}', 'JobsController@update');
            $router->delete('/{id}', 'JobsController@destroy');
        });

        /**
         * Applications
         */
        $router->group(['prefix' => '{id}/applications'], function() use(&$router) {
            /**
             * Applications open
             */
            $router->get('/{applicationId}', 'ApplicationsController@show');

            /**
             * Applications applicant only
             */
            $router->group(['middleware' => 'role:applicant'], function() use(&$router) {
                $router->post('/', 'ApplicationsController@store');
                $router->get('/', 'ApplicationsController@index');
                $router->put('/{applicationId}', 'ApplicationsController@update');
                $router->delete('/{applicationId}', 'ApplicationsController@destroy');
            });
        });

    });
});