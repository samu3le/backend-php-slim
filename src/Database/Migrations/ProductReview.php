<?php

namespace App\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class ProductReview
{
    public static function up()
    {
        if (!Capsule::schema()->hasTable('products_reviews')) {
            Capsule::schema()->create('products_reviews', function ($table) {
                $table->bigIncrements('id');

                $table->unsignedBigInteger('product_id');
                $table->foreign('product_id')->references('id')->on('products');

                $table->unsignedBigInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('products_reviews');

                $table->string('content')->nullable();

                $table->smallInteger('rating')->default(5);

                $table->unsignedBigInteger('created_by');
                $table->foreign('created_by')->references('id')->on('users');

                $table->timestamps();
            });

            Capsule::table('permissions')->insert(
                [
                    [
                        'name' => 'products_categories',
                        'alias' => 'products_categories',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products',
                        'alias' => 'products',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'cart',
                        'alias' => 'cart',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'users',
                        'alias' => 'users',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'roles',
                        'alias' => 'roles',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'permissions',
                        'alias' => 'permissions',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products_categories.get_all.admin',
                        'alias' => 'products_categories.get_all.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products_categories.find.admin',
                        'alias' => 'products_categories.find.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products_categories.create.admin',
                        'alias' => 'products_categories.create.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products_categories.update.admin',
                        'alias' => 'products_categories.update.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products_categories.state.admin',
                        'alias' => 'products_categories.state.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products.get_all.admin',
                        'alias' => 'products.get_all.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products.find.admin',
                        'alias' => 'products.find.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products.create.admin',
                        'alias' => 'products.create.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products.update.admin',
                        'alias' => 'products.update.admin',
                        'created_by' => 1,
                    ],
                    [
                        'name' => 'products.state.admin',
                        'alias' => 'products.state.admin',
                        'created_by' => 1,
                    ],
                    
                ],
            );
        }
    }

    public static function down()
    {
        Capsule::schema()->dropIfExists('permissions');
    }
}