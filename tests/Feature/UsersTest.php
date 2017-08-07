<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Sijot\Mail\BlockEmailNotification;
use Sijot\Mail\UserCreationMail;
use Sijot\Notifications\BlockNotification;
use Sijot\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class UsersTest
 *
 * @package Tests\Feature
 */
class UsersTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the index route for the user section.
     *
     * @test
     * @group all
     */
    public function testUsersIndex()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('users.index'))
            ->assertStatus(200);
    }

    /**
     * Test if we can get a specific user.
     *
     * @test
     * @group all
     */
    public function testGetByValidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('users.getId', $user->id))
            ->assertStatus(200)
            ->json();
    }

    /**
     * Test if we can get an 404 on a invalid user request.
     *
     * @test
     * @group all
     */
    public function testGetByInvalidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('users.getId', 1000))
            ->assertStatus(404);
    }

    /**
     * Test if we can ban a user. Without validation errors.
     *
     * @test
     * @group all
     */
    public function testBanUserValidIdNoValidationError()
    {
        Notification::fake();
        Mail::fake();

        $user = factory(User::class, 2)->create();

        $input = [
            'id' => $user[1]->id,
            'eind_datum' => '10-11-2018',
            'reason' => 'Ik ben een beschrijving'
        ];

        $this->actingAs($user[0])
            ->seeIsAuthenticatedAs($user[0])
            ->post(route('users.block'), $input)
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.level' => 'success']);

        Mail::assertSent(BlockEmailNotification::class, function ($mail) use ($user) {
            return $mail->hasTo($user[1]->email);
        });

        Notification::assertSentTo($user, BlockNotification::class);
    }

    /**
     * Test the error message. If a current logged in user bans himself.
     *
     * @test
     * @group all
     */
    public function testBanCurrentLoggedInUser()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('users.block'), ['id' => $user->id, 'reason' => 'Ik ben een rede tot blokkering', 'eind_datum' => '10/10/2018'])
            ->assertStatus(302)
            ->assertSessionHas([
                'flash_notification.0.message' => 'Je kan jezelf niet blokkeren.',
                'flash_notification.0.level'   => 'danger',
            ]);
    }


    /**
     * Test if we can ban a user. With validation errors.
     *
     * @test
     * @group all
     */
    public function testBanUserValidIdValidationError()
    {
        $user        = factory(User::class, 2)->create();
        $input['id'] = $user[1]->id;

        $this->actingAs($user[0])
            ->seeIsAuthenticatedAs($user[0])
            ->post(route('users.block'), $input)
            ->assertStatus(200)
            ->assertSessionMissing(['class' => 'alert alert-success'])
            ->assertSessionHasErrors();
    }

    /**
     * Test if wa can ban an user with an invalid id.
     *
     * @test
     * @group all
     */
    public function testBanUserInvalidId()
    {
        $user        = factory(User::class)->create();

        $input['id']         = 1000;
        $input['eind_datum'] = '10-11-2016';
        $input['reason']     = 'Ik ben een wachtwoord';

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('users.block'), $input)
            ->assertStatus(404);
    }

    /**
     * Test if we can unblock a user when the user in case is already active.
     *
     * @test
     * @group all
     */
    public function testUnblockValidIdNotBanned()
    {
        $user = factory(User::class, 2)->create();

        $this->actingAs($user[0])
            ->seeIsAuthenticatedAs($user[0])
            ->get(route('users.unblock', ['id' => $user[1]]))
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.message' => 'Wij konden de gebruiker niet activeren.']);
    }

    /**
     * Test if we can unblock a banned user.
     *
     * @test
     * @group all
     */
    public function testUnblockActivateUserCorrect()
    {
        $userActive  = factory(User::class)->create();
        $user2       = factory(User::class)->create();

        User::find($user2->id)->ban([
            'comment'    => 'Ik ben een reden',
            'expired_at' => Carbon::parse('26-6-2017')
        ]);

        $this->actingAs($userActive)
            ->seeIsAuthenticatedAs($userActive)
            ->get(route('users.unblock', ['id' => $user2->id]))
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.message' => 'De gebruiker is terug geactiveerd']);
    }

    /**
     * Test the output when the user is not found in the database with his id.
     *
     * @test
     * @group all
     */
    public function testUnblockInvalidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('users.unblock', ['id' => 1000]))
            ->assertStatus(404);
    }

    /**
     * Test inserting new user. (with validation errors)
     *
     * @test
     * @group all
     */
    public function testStoreValidationError()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('users.store'), [])
            ->assertStatus(200)
            ->assertSessionHasErrors()
            ->assertSessionMissing(['flash_notification.0.message' => 'De login is aangemaakt.']);
    }

    /**
     * Test inserting new user. (with validation errors)
     *
     * @test
     * @group all
     */
    public function testStoreNoValidationErr()
    {
        Mail::fake();

        $user = factory(User::class)->create();

        $input = [
            'name'                  => 'John Doe',
            'email'                 => 'topairy@gmail.com',
            'password'              => 'Ikbeneenwachtwoord!',
            'password_confirmation' => 'Ikbeneenwachtwoord!'
        ];

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->post(route('users.store'), $input)
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.message' => 'De login is aangemaakt.']);

        Mail::assertSent(UserCreationMail::class, function ($mail) use ($input) {
            return $mail->data['name']  === $input['name']  &&
                $mail->data['email']    === $input['email'] &&
                $mail->data['password'] === $input['password'];
        });

        Mail::assertSent(UserCreationMail::class, function ($mail) use ($input) {
            return $mail->hasTo($input['email']);
        });

        $this->assertDatabaseHas('users', ['name' => $input['name'], 'email' => $input['email']]);
    }

    /**
     * Test if we can delete a user.
     *
     * @test
     * @group all
     */
    public function testUserDeleteValidId()
    {
        $user = factory(User::class, 2)->create();

        $this->actingAs($user[0])
            ->seeIsAuthenticatedAs($user[0])
            ->get(route('users.delete', ['id' => $user[1]->id]))
            ->assertStatus(302)
            ->assertSessionHas(['flash_notification.0.message' => "{$user[1]->name} Is verwijderd uit het systeem."]);
    }

    /**
     * Test if we get an invalid response on user delete.
     *
     * @test
     * @group all
     */
    public function testUserDeleteInvalidId()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->seeIsAuthenticatedAs($user)
            ->get(route('users.delete', ['id' => 1000]))
            ->assertStatus(404);
    }
}
