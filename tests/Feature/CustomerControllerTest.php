<?php

namespace Tests\Feature;

use App\Models\Customer;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class CustomerControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test Customer
     */
    public function testMethodAll()
    {
        factory(Customer::class)->create(['email' => 'test@admin.com']);

        $response = $this->call('GET', '/customers');
        $this->assertEquals(200, $response->status());

        $this->json('GET', '/customers')
             ->seeJson([
                    'status' => 'ok',
                ])
            ->seeJsonStructure([ 'data' => [ [ 'fullname', 'email', 'username', 'gender', 'country', 'city', 'phone' ] ] ]);
    }
}
