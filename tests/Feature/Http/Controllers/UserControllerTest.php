<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\LocalExchangeRateService;
use App\Support\Facades\ExchangeRate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Mockery\MockInterface;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test users index method fetches and returns user listing in view
     *
     * @test
     *
     * @return void
     */
    public function usersIndexTest()
    {
        $user = $this->mock(User::class, function (MockInterface $user) {
            $user->shouldReceive('get')
                 ->once()
                 ->andReturn(new Collection());
        });

        $userController = new UserController($user);

        $response = $userController->index();

        $data = $response->getData();

        $this->assertInstanceOf(View::class, $response);
        $this->assertInstanceOf(Collection::class, $data['users']);
    }


    /**
     * Test user create view is returned in response with currency options
     *
     * @test
     *
     * @return void
     */
    public function userCreateTest()
    {
        $user = $this->mock(User::class);

        $userController = new UserController($user);

        $response = $userController->create();

        $this->assertInstanceOf(View::class, $response);
    }


    /**
     * Store Test
     *
     * @test
     *
     * @return void
     */
    public function userStoreTest()
    {
        $data = [
            'name' => 'Tim Jones',
            'company_name' => 'Tim Jones Accountancy Ltd',
            'job_title' => 'Head Accountant',
            'phone' => '+44 7456 123456',
            'email' => 'timjones@example.com',
            'hourly_rate' => '55.00',
            'currency' => 'GBP'
        ];

        $request = $this->mock(
            StoreUserRequest::class,
            function (MockInterface $request) use ($data) {
                $request->shouldReceive('validated')
                        ->once()
                        ->andReturn($data);
            }
        );

        $user = $this->mock(
            User::class,
            function (MockInterface $user) use ($data) {
                $user->shouldReceive('create')
                     ->with($data)
                     ->once();
            }
        );

        $userController = new UserController($user);

        $response = $userController->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);

        $this->assertSame('Executive profile created!', $response->getSession()->get('success'));
    }


    /**
     * Show Test
     *
     * @test
     *
     * @return void
     */
    public function userShowTest()
    {
        // Create test user - note will be deleted after this test (ref. trait)
        $user = User::create([
            'name' => 'Tim',
            'company_name' => 'Tim Jones Accountancy Ltd',
            'job_title' => 'Head Accountant',
            'phone' => '+44 7456 123456',
            'email' => 'timjones@example.com',
            'hourly_rate' => '55.00',
            'currency' => 'GBP'
        ]);

        /* Create non-mocked request for test (will bypass validation) */
        $request = ShowUserRequest::create('/users/1', 'GET', ['CUR' => 'USD']);

        // Force local driver as mock
        ExchangeRate::shouldReceive('fetchRates')
            ->once()
            ->with('GBP')
            ->andReturn(
                (new LocalExchangeRateService())->getExchangeRateLUT()[$user->currency]
            );

        ExchangeRate::shouldReceive('convertCurrency')
            ->once()
            ->with('55.00', 1.3)
            ->andReturn(71.50);

        $userController = new UserController(new User());

        $response = $userController->show($request, $user);
    }
}
