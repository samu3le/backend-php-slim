<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\DataParser;

use App\Http\Middleware\Auth;
use App\Http\Middleware\CanPermission;
use App\Http\Middleware\CheckPermissionAdmin;

use App\Http\Middleware\Validations;
use App\Http\Middleware\Validations\Requests;
use App\Http\Controllers;

Route::prefix('v1')->middleware([DataParser::class])->group(function () {

    Route::prefix('auth')->group(function () {

        Route::middleware([
            Requests\AuthValidation\SignUp::class,
        ])
        ->post('sign_up', Controllers\AuthController\SignUp::class);

        Route::middleware([
            Requests\AuthValidation\SignIn::class,
        ])
        ->post('sign_in', Controllers\AuthController\SignIn::class);

        Route::middleware([
            Auth::class,
        ])
        ->post('sign_out', Controllers\AuthController\SignOut::class);

    });

    Route::middleware([
        Validations\Requests\Pagination::class,
        Requests\ProductCategoryValidation\GetAll::class
    ])
    ->get('products_categories', Controllers\ProductCategoryController\GetAllList::class);

    Route::middleware([
        Requests\ProductCategoryValidation\GetBySlug::class
    ])
    ->get('product_category/{slug}', Controllers\ProductCategoryController\GetBySlug::class);

    Route::middleware([
        Auth::class,
    ])->group(function () {
        Route::prefix('roles')->group(function () {

            Route::middleware([
                Validations\Requests\Pagination::class,
                Requests\RoleValidation\GetAll::class,
            ])
            ->get('get_all', Controllers\RoleController\GetAll::class);

            Route::middleware([
                Requests\RoleValidation\FindOne::class,
            ])
            ->get('find_one', Controllers\RoleController\FindOne::class);

            Route::middleware([
                Requests\RoleValidation\Create::class,
            ])
            ->post('create', Controllers\RoleController\Create::class);

            Route::middleware([
                Requests\RoleValidation\Update::class,
            ])
            ->post('update', Controllers\RoleController\Update::class);

        });

        Route::middleware([

        ])->prefix('products_categories')->group(function () {

            Route::middleware([
                Validations\Requests\Pagination::class,
                Requests\ProductCategoryValidation\GetAll::class
            ])
            ->get('get_all',  Controllers\ProductCategoryController\GetAll::class);

            Route::middleware([
                Requests\ProductCategoryValidation\Find::class
            ])
            ->get('find',  Controllers\ProductCategoryController\Find::class);

            Route::middleware([
                CheckPermissionAdmin::class.':products_categories.create.admin',
                Requests\ProductCategoryValidation\Create::class,
            ])
            ->post('create', Controllers\ProductCategoryController\Create::class);

            Route::middleware([
                Requests\ProductCategoryValidation\Update::class
            ])
            ->post('update', Controllers\ProductCategoryController\Update::class);

            Route::middleware([
                Requests\ProductCategoryValidation\State::class
            ])
            ->post('state', Controllers\ProductCategoryController\State::class);

        });

        Route::middleware([

        ])->prefix('permissions')->group(function () {

            Route::middleware([
                Validations\Requests\Pagination::class,
                Requests\PermissionValidation\GetAll::class
            ])
            ->get('get_all',  Controllers\PermissionController\GetAll::class);

            Route::middleware([
                Requests\PermissionValidation\Find::class
            ])
            ->get('find',  Controllers\PermissionController\Find::class);

            Route::middleware([
                Requests\PermissionValidation\Create::class
            ])
            ->post('create', Controllers\PermissionController\Create::class);

            Route::middleware([
                Requests\PermissionValidation\Update::class
            ])
            ->post('update', Controllers\PermissionController\Update::class);

            Route::middleware([
                Requests\PermissionValidation\State::class
            ])
            ->post('state', Controllers\PermissionController\State::class);

        });

        Route::middleware([
            CanPermission::class.':users',
            ])->prefix('users')->group(function () {

                Route::middleware([
                    Validations\Requests\Pagination::class,
                    Requests\UserValidation\GetAll::class
                ])
                ->get('get_all',  Controllers\UserController\GetAll::class);

                Route::middleware([
                    Requests\UserValidation\Find::class
                ])
                ->get('find',  Controllers\UserController\Find::class);

                Route::middleware([
                    Requests\UserValidation\Create::class
                ])
                ->post('create', Controllers\UserController\Create::class);

                Route::middleware([
                    Requests\UserValidation\Update::class
                ])
                ->post('update', Controllers\UserController\Update::class);

                Route::middleware([
                    Requests\UserValidation\State::class
                ])
                ->post('state', Controllers\UserController\State::class);

            });

    });
});
