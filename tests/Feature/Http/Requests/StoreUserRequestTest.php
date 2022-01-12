<?php

namespace Tests\Feature\Http\Requests;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreUserRequestTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    const UNIQUE_EMAIL = 'tim__jones@example.com';

    /**
     * Ensure authorisation passes by default
     *
     * @test
     *
     * @return void
     */
    public function verifyDefaultPassAuthorisation()
    {
        $request = new StoreUserRequest();

        $this->assertTrue($request->authorize());
    }


    /**
     * Check valid data is accepted
     *
     * @test
     *
     * @dataProvider provideValidData
     *
     * @return void
     */
    public function acceptValidData(array $data)
    {
        $request = new StoreUserRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }


    /**
     * Provide data set containing valid data
     *
     * @return array
     */
    public function provideValidData()
    {
        /* To enable faker set up,  application creation is required as data
           providers are called by PHPUnit before tests are setUp and run */
        $this->createApplication();

        $this->setUpFaker();

        // Random generated data provision (valid data)
        $name = $this->faker->name;
        $company_name = $this->faker->sentence(3);
        $job_title = $this->faker->sentence(2);
        $phone = $this->faker->randomElement([
                        // Formats to satisfy
                        '07654 123456',
                        '07654123456',
                        '+44 (0)1234 567890',
                        '+44(0)1234 567890',
                        '+44(0) 1234 567890',
                        '01234 567890',
                        '01234567890'
                    ]);
        $email = $this->faker->unique()->safeEmail;
        $hourly_rate = $this->faker->randomFloat(2, 0, 999999);
        $currency = $this->faker->randomElement(
            config('exchangerate.allowed_currencies')
        );

        return [
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    // Delta: company name missing is valid (not "required")
                    'name' => $name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ]
        ];
    }


    /**
     * Check invalid data is rejected
     *
     * @test
     *
     * @dataProvider provideInvalidData
     *
     * @return void
     */
    public function rejectValidData(array $data)
    {
        // Create test user - note will be deleted after this test (ref. trait)
        $user = User::create([
            'name' => 'Tim Jones',
            'company_name' => 'Tim Jones Accountancy Ltd',
            'job_title' => 'Head Accountant',
            'phone' => '+44 7456 123456',
            'email' => self::UNIQUE_EMAIL,
            'hourly_rate' => '55.00',
            'currency' => 'GBP'
        ]);

        $request = new StoreUserRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }


    /**
     * Provide data set containing random invalid data
     *
     * @return array
     */
    public function provideInvalidData()
    {
        /* To enable faker set up,  application creation is required as data
           providers are called by PHPUnit before tests are setUp and run */
        $this->createApplication();

        $this->setUpFaker();

        // Random generated data provision (valid data)
        $name = $this->faker->name;
        $company_name = $this->faker->sentence(3);
        $job_title = $this->faker->sentence(2);
        $phone = $this->faker->randomElement([
                        // Formats to satisfy
                        '07654 123456',
                        '07654123456',
                        '+44 (0)1234 567890',
                        '+44(0)1234 567890',
                        '+44(0) 1234 567890',
                        '01234 567890',
                        '01234567890'
                    ]);
        $email = $this->faker->unique()->safeEmail;
        $hourly_rate = $this->faker->randomFloat(2, 0, 999999);
        $currency = $this->faker->randomElement(
            config('exchangerate.allowed_currencies')
        );

        // Ensure faked email is never set the same as UNIQUE_EMAIL constant
        if ($email == self::UNIQUE_EMAIL) {
            $email = substr_replace($email, "a", 0, 0);
        }

        // Random generated data provision (invalid data)
        $randomEnumerationLiteral = strtoupper(Str::random(3));

        // Ensure allowed currency enumerations literals are never used
        $randomEnumerationLiteral = str_replace(
            config('exchangerate.allowed_currencies'),
            ['XXX', 'XXX', 'XXX'],
            $randomEnumerationLiteral
        );

        return [
            [
                [
                    'name' => '', // name missing
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => '', // job title missing
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => '', // phone missing
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => '', // email missing
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ],
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => null, // hourly rate missing
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => '' // currency missing
                ]
            ],
            [
                [
                    'name' => str_repeat('a', 256), // over 255 chars
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => str_repeat('a', 256), // over 255 chars
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => str_repeat('a', 256), // over 255 chars
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => str_repeat('a', 256), // over 255 chars
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => '0034608123456', // Non UK number
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => 'tim__jones@example.com', // non unique email
                    'hourly_rate' => $hourly_rate,
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => 'abc', // non numeric
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => -10.02, // negative value
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => 1000000, // exceeds max limit
                    'currency' => $currency
                ]
            ],
            [
                [
                    'name' => $name,
                    'company_name' => $company_name,
                    'job_title' => $job_title,
                    'phone' => $phone,
                    'email' => $email,
                    'hourly_rate' => $hourly_rate,
                    'currency' => $randomEnumerationLiteral // Invalid currency
                ]
            ]
        ];
    }
}
