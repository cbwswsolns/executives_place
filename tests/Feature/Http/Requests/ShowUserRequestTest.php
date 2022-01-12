<?php

namespace Tests\Feature\Http\Requests;

use App\Http\Requests\ShowUserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ShowUserRequestTest extends TestCase
{
    /**
     * Ensure authorisation passes by default
     *
     * @test
     *
     * @return void
     */
    public function verifyDefaultPassAuthorisation()
    {
        $request = new ShowUserRequest();

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
        $request = new ShowUserRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }


    /**
     * Provide data set containing valid data (whitelisted strings)
     *
     * @return array
     */
    public function provideValidData()
    {
        /* To enable access to config, application creation is required as data
           providers are called by PHPUnit before tests are setUp and run */
        $this->createApplication();

        foreach (config('exchangerate.allowed_currencies') as $cur) {
            $dataSet[] = [['CUR' => $cur ]];
        }

        return $dataSet;
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
        /* To enable access to config, application creation is required as data
           providers are called by PHPUnit before tests are setUp and run */
        $this->createApplication();

        $request = new ShowUserRequest();

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
        /* To enable access to config, application creation is required as data
           providers are called by PHPUnit before tests are setUp and run */
        $this->createApplication();

        $randomEnumerationLiteral = strtoupper(Str::random(3));

        // Ensures allowed currency enumerations literals are never used
        $randomEnumerationLiteral = str_replace(
            config('exchangerate.allowed_currencies'),
            ['XXX', 'XXX', 'XXX'],
            $randomEnumerationLiteral
        );

        return [
            [
                ['CUR' => $randomEnumerationLiteral]
            ]
        ];
    }
}
