<?php

namespace Tests\Feature;

use Sijot\Categories;
use Sijot\News;
use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class NewsTest
 *
 * @package Tests\Feature
 */
class NewsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the backend view for the news items.
     *
     * @test
     * @group all
     */
    public function testIndexRoute()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.index'))
            ->assertStatus(200);
    }

    /**
     * Test the view for creating a new news item.
     *
     * @test
     * @group all
     */
    public function testCreateview()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.create'))
            ->assertStatus(200);
    }

    /**
     * Test if we can get an json response for one specific news item.
     *
     * @test
     * @group all
     */
    public function testGetByIdNoErr()
    {
        $user = factory(User::class)->create();
        $news = factory(News::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.json', ['id' => $news->id]))
            ->assertStatus(200)
            ->json();
    }

    /**
     * Test the response when we gat an invalid news item.
     *
     * @test
     * @group all
     */
    public function testGetByIdErr()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.json', ['id' => 2000]))
            ->assertStatus(404);
    }

    /**
     * Store a new news item. (No validation errors)
     *
     * @test
     * @group all
     */
    public function testStoreNoValidationError()
    {
        $user = factory(User::class)->create();

        $input = [
            'author_id' => $user->id,
            'publish'   => 'N',
            'title'     => 'Ik ben een titel',
            'message'   => 'Ik ben een nieuwsbericht.',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('news.store'), $input)
            ->assertStatus(302)
            ->assertSessionHas([
                'class'     => 'alert alert-success',
                'message'   => 'Het nieuwsbericht is opgeslagen.'
            ]);

        $this->assertDatabaseHas('news', $input);
    }

    /**
     * Store a new news item. (No validation errors)
     *
     * @test
     * @group all
     */
    public function testStoreNoValidationErrorWithCategories()
    {
        $user       = factory(User::class)->create();
        $categories = factory(Categories::class, 3)->create();

        $input = [
            'author_id'  => $user->id,
            'publish'    => 'N',
            'categories' => [$categories[0]->id, $categories[1]->id, $categories[2]->id],
            'title'      => 'Ik ben een titel',
            'message'    => 'Ik ben een nieuwsbericht.',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('news.store'), $input)
            ->assertStatus(302)
            ->assertSessionHas([
                'class'     => 'alert alert-success',
                'message'   => 'Het nieuwsbericht is opgeslagen.'
            ]);

        // $this->assertDatabaseHas('news', $input);

        $this->assertDatabaseHas('categories_news', ['categories_id' => $categories[0]->id]);
        $this->assertDatabaseHas('categories_news', ['categories_id' => $categories[1]->id]);
        $this->assertDatabaseHas('categories_news', ['categories_id' => $categories[2]->id]);
    }

    /**
     * Try to create a new news item. (with validation errors)
     *
     * @test
     * @group all
     */
    public function testStoreWithValidationError()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('news.store'))
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing([
                'class'   => 'alert alert-success',
                'message' => 'Het nieuwsbericht is opgeslagen.',
            ]);
    }

    /**
     * Try to show a specific news item.
     *
     * @test
     * @group all
     */
    public function testShowValid()
    {
        $user = factory(User::class)->create();
        $news = factory(News::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.show', ['id' => $news->id]))
            ->assertStatus(200);
    }


    /**
     * Check for the response when the news item is not found in the database.
     *
     * @test
     * @group all
     */
    public function testShowInValid()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.show', ['id' => 1000]))
            ->assertStatus(404);
    }

    /**
     * Try to update a news item when there iss a incorrect id.
     *
     * @test
     * @group all
     */
    public function testUpdateIdNotFound()
    {
        $user = factory(User::class)->create();

        $input = [
            'author_id' => $user->id,
            'publish'   => 'N',
            'title'     => 'Ik ben een titel',
            'message'   => 'Ik ben een nieuwsbericht.',
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('news.update', ['id' => 1000]), $input)
            ->assertStatus(404);
    }

    /**
     * Try to insert a new news item. (without validation errors)
     *
     * @test
     * @group all
     */
    public function testUpdateWithValidationErrors()
    {
        $user = factory(User::class)->create();
        $news = factory(News::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('news.update', ['id' => $news->id]))
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing([
                'class'     => 'alert alert-success',
                'message'   => 'Het nieuwsbericht is aangepast.'
            ]);
    }

    /**
     * Try to insert a new news item. (without validation errors)
     *
     * @test
     * @group all
     */
    public function testUpdateNoValidationErrors()
    {
        $user = factory(User::class)->create();
        $news = factory(News::class)->create();

        $input = [
            'author_id' => $user->id,
            'publish'   => 'N',
            'title'     => 'Ik ben een titel',
            'message'   => 'Ik ben een nieuwsbericht.',
        ];

        $old = [
            'author_id' => $news->author_id,
            'publish'   => $news->publish,
            'title'     => $news->title,
            'message'   => $news->message,
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('news.update', ['id' => $news->id]), $input)
            ->assertStatus(302)
            ->assertSessionHas([
                'class'     => 'alert alert-success',
                'message'   => 'Het nieuwsbericht is aangepast.'
            ]);

        $this->assertDatabaseMissing('news', $old);
        $this->assertDatabaseHas('news', $input);
    }

    /**
     * Try to change the status off a news item with an invalid id.
     *
     * @test
     * @group all
     */
    public function testStatusInvalidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.status', ['status' => 'Y', 'id' => 1000]))
            ->assertStatus(404);
    }

    /**
     * Try to change the news item id in the database to publish.
     *
     * @test
     * @group all
     */
    public function testStatusPublish()
    {
        $user = factory(User::class)->create();
        $news = factory(News::class)->create(['publish' => 'Y']);

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.status', ['status' => 'Y', 'id' => $news->id]))
            ->assertStatus(302)
            ->assertSessionHas([
                'class'   => 'alert alert-success',
                'message' => 'Het nieuwsbericht is gepubliceerd.'
            ]);

        $this->assertDatabaseHas('news', ['publish' => 'Y']);
    }

    /**
     * Try to change the status to a draft in the database.
     *
     * @test
     * @group all
     */
    public function testStatusDraft()
    {
        $user = factory(User::class)->create();
        $news = factory(News::class)->create(['publish' => 'Y']);

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.status', ['status' => 'N', 'id' => $news->id]))
            ->assertStatus(302)
            ->assertSessionHas([
                'class'   => 'alert alert-success',
                'message' => 'Het nieuws bericht is naar een klad versie gezet.'
            ]);

        $this->assertDatabaseHas('news', ['publish' => 'N']);
    }

    /**
     * Try to delete an news item with a valid id.
     *
     * @test
     * @group all
     */
    public function testDeleteValidId()
    {
        $user = factory(User::class)->create();
        $news = factory(News::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.delete', ['id' => $news->id]))
            ->assertStatus(302)
            ->assertSessionHas([
                'class'   => 'alert alert-success',
                'message' => 'Het nieuwsbericht is verwijderd.'
            ]);
    }

    /**
     * Try to delete news item with incorrect id.
     *
     * @test
     * @group all
     */
    public function testDeleteInvalidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('news.delete', ['id' => 1000]))
            ->assertStatus(404);
    }
}
