<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Tests\TestCase;

class RandomTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_apis_response_correctly()
    {
        $response1 = $this->get('/api/test');
        
        $response1->assertStatus(200);


        // $response2 = $this->get('/api/test/show/2');
 
        // if(($response2->) || ($response2->))
        //     $response2->assertValid();


        // $response3 = $this->post('/api/test/create?test={"tests": "Item Name"}');
 
        // $response3->assertStatus(201);
    }
}
