<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Application redirects to Users (index listing) route on home request
     *
     * @test
     *
     * @return void
     */
    public function appRedirectsToUsersRouteOnHomeRequest()
    {
        $response = $this->get('/');

        $response->assertRedirect('/users');
    }


    /**
     * Application returns successful response on Users (index listing) request
     *
     * @test
     *
     * @return void
     */
    public function appReturnsSussessfulResponseOnUsersRequest()
    {
        $response = $this->get('/users');

        $response->assertStatus(200)
                 ->assertViewIs('executives.index')
                 ->assertViewHas('users');
    }


    /**
     * Application returns successful response on Users create request
     *
     * @test
     *
     * @return void
     */
    public function appReturnsSussessfulResponseOnUsersCreateRequest()
    {
        $response = $this->get('/users/create');

        $response->assertStatus(200)
                 ->assertViewIs('executives.create')
                 ->assertViewHas('currencies');
    }


    /**
     * Application passes validation and returns successful redirect
     * on User store request
     *
     * @test
     *
     * @return void
     */
    public function appReturnsSussessfulRedirectOnUsersStoreRequest()
    {
        $response = $this->post('/users', [
                        'name' => 'Tim Jones',
                        'company_name' => 'Tim Jones Accountancy Ltd',
                        'job_title' => 'Head Accountant',
                        'phone' => '+44 7456 123456',
                        'email' => 'timjones@example.com',
                        'hourly_rate' => '55.00',
                        'currency' => 'GBP'
                    ]);

        $response->assertRedirect('users')
                 ->assertSessionHas('success', 'Executive profile created!');
    }


    /**
     * Application validation fails on Users store request with invalid
     * POST data and redirects as expected
     *
     * @test
     *
     * @return void
     */
    public function appValidationFailsOnUsersStoreRequest()
    {
        $response = $this->from('/users/create')->post('/users', [
                        'name' => '',
                        'company_name' => 'Tim Jones Accountancy Ltd',
                        'job_title' => 'Head Accountant',
                        'phone' => '+44 7456 123456',
                        'email' => 'timjones', // Invalid email field
                        'hourly_rate' => '55.00Z',
                        'currency' => 'GBPT'
                    ]);

        $response->assertSessionHasErrors(['name', 'email', 'hourly_rate', 'currency']);

        $response->assertRedirect('/users/create');
    }


    /**
     * Application returns successful response on Users show request
     *
     * @test
     *
     * @return void
     */
    public function appReturnsSuccessfulResponseOnUsersShowRequest()
    {
        Config::set('exchangerate.driver', 'local');

        $userData = [
            'name' => 'Tim Jones',
            'company_name' => 'Tim Jones Accountancy Ltd',
            'job_title' => 'Head Accountant',
            'phone' => '+44 7456 123456',
            'email' => 'timjones@example.com',
            'hourly_rate' => '55.00',
            'currency' => 'GBP'
        ];

        // Create test user - note will be deleted after this test (ref. trait)
        $user = User::create($userData);

        $response = $this->get(route('users.show', [$user->id, 'CUR' => 'USD']));

        $response->assertStatus(200)
                 ->assertJson([
                    'user' => $userData,
                    'exchangeRate' => 1.3,
                    'convertedSalary' => 71.50,
                    'convertedSalaryCurrency' => 'USD'
                 ]);
    }


    /**
     * Application validation fails on Users store request with invalid
     * query string parameter data and redirects as expected
     *
     * @test
     *
     * @return void
     */
    public function appValidationFailsOnUsersShowRequest()
    {
        Config::set('exchangerate.driver', 'api');

        $user = User::create([
            'name' => 'Tim Jones',
            'company_name' => 'Tim Jones Accountancy Ltd',
            'job_title' => 'Head Accountant',
            'phone' => '+44 7456 123456',
            'email' => 'timjones@example.com',
            'hourly_rate' => '55.00',
            'currency' => 'GBP'
        ]);

        $response = $this->from('/users')->get(route('users.show', [$user->id, 'CUR' => 'USDT']));

        $response->assertSessionHasErrors(['CUR']);

        //dd(get_class($response));

        $response->assertRedirect('/users');
    }


    /**
     * Set the URL of the previous request.
     *
     * @param  string  $url
     * @return $this
     */
    public function from(string $url)
    {
        $this->app['session']->setPreviousUrl($url);

        return $this;
    }
}
