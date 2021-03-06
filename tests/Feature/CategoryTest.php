<?php

namespace Tests\Feature;

use Sijot\Categories;
use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\{WithoutMiddleware, DatabaseTransactions, DatabaseMigrations};

class CategoryTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Try to insert a new category without errors.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::insert()
     */
    public function testInsertNoError()
    {
        $user = factory(User::class)->create();

        $input = [
            'author_id'     => $user->id,
            'module'        => 'news',
            'name'          => 'test',
            'description'   => 'description',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('category.insert'), $input)
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.message' => trans('category.flash-insert')]);

        $this->assertDatabaseHas('categories', $input);
    }

    /**
     * Category insert with errors.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::insert()
     */
    public function testInsertError()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('category.insert'), [])
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing(['flash_notification.0.message' => trans('category.flash-insert')]);
    }

    /**
     * Test the json response for a specific category.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::getById()
     */
    public function testJsonResponse()
    {
        $user     = factory(User::class)->create();
        $category = factory(Categories::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('category.json', ['id' => $category->id]))
            ->assertStatus(200)
            ->json();
    }

    /**
     * Test an invalid json response.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::getById()
     */
    public function testJsonResponseInvalid()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('category.json', ['id' => 1000]))
            ->assertStatus(404);
    }

    /**
     * Test a category update with an invalid id.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::edit()
     */
    public function testResponseEditInvalidId()
    {
        $user = factory(User::class)->create();

        $input = [
            'categoryId'    => 100,
            'author_id'     => $user->id,
            'module'        => 'news',
            'name'          => 'test',
            'description'   => 'description',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('category.edit'), $input)
            ->assertStatus(404);
    }

    /**
     * Test if we can edit a category when validation fails.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::edit()
     */
    public function testResponseErrEditValidation()
    {
        $user     = factory(User::class)->create();
        $category = factory(Categories::class)->create();

        $input = ['categoryId'    => $category->id];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('category.edit'), $input)
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing(['flash_notification.0.message' => trans('category.flash-edit')]);
    }

    /**
     * Test if the edit from the category has been happend successful.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::edit()
     */
    public function testEditNoErrors()
    {
        $user     = factory(User::class)->create();
        $category = factory(Categories::class)->create();

        $input = [
            'categoryId'    => $category->id,
            'author_id'     => $user->id,
            'module'        => 'news title',
            'name'          => 'test name',
            'description'   => 'description test',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('category.edit'), $input)
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.message' => trans('category.flash-edit')]);
    }

    /**
     * Test if we can delete a category.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::destroy()
     */
    public function testDeleteCategory()
    {
        // TODO: Test out relation ship.

        $user     = factory(User::class)->create();
        $category = factory(Categories::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('category.delete', ['id' => $category->id]))
            ->assertStatus(302)
            ->assertSessionHas([
                'flash_notification.0.level'   => 'success',
                'flash_notification.0.message' => trans('category.flash-delete')
            ]);
    }

    /**
     * Test if we can delete an unvalid tag.
     *
     * @test
     * @group  all
     * @covers \Sijot\Http\Controllers\CategoryController::destroy()
     */
    public function testDeleteInvalid()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('category.delete', ['id' => 1000]))
            ->assertStatus(404)
            ->assertSessionMissing([
                'flash_notification.0.level'   => 'success',
                'flash_notification.0.message' => trans('category.flash-delete')
            ]);
    }
}
