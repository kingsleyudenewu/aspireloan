<?php

namespace Tests\Unit;

use App\Traits\ApiResponse;
use Tests\TestCase;

class ApiResponseTest extends TestCase
{
    protected $apiResponseClass;

    public function setUp(): void
    {
        parent::setUp();
        $this->apiResponseClass = new class { use ApiResponse; };
    }

    /**
     * Test success response
     */
    public function test_success_response()
    {
        $response = $this->apiResponseClass->successResponse('Success Response',[]);
        $data = $response->getData();

        $this->assertEquals($data->status, true);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($data->message, 'Success Response');
        $this->assertEquals($data->data, []);
    }

    /**
     *
     */
    public function test_client_error_response()
    {
        $response = $this->apiResponseClass->clientError('Client Error Response', 400);
        $data = $response->getData();

        $this->assertEquals($response->getStatusCode(), 400);
        $this->assertEquals($data->message, 'Client Error Response');
    }

    /**
     *
     */
    public function test_not_found_response()
    {
        $response = $this->apiResponseClass->notFoundResponse('Data Not Found');
        $data = $response->getData();

        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals($data->message, 'Data Not Found');
    }

    /**
     *
     */
    public function test_forbidden_response()
    {
        $response = $this->apiResponseClass->forbiddenRequestAlert('Forbidden');
        $data = $response->getData();

        $this->assertEquals($response->getStatusCode(), 403);
        $this->assertEquals($data->message, 'Forbidden');
    }
}
