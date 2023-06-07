<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use MongoDB\Client;

class UserTest extends TestCase
{
    protected $mongoClient;
    protected $testDatabaseName = 'db_vehicles_test';

    public function setUp(): void
    {
        parent::setUp();

        // Create a MongoDB client instance
        $this->mongoClient = new Client();

        // Set the default database to the test database
        $this->app['config']->set('database.connections.mongodb.database', $this->testDatabaseName);

        // Migrate the test database
        Artisan::call('migrate', ['--database' => 'mongodb']);

        // Seed the test database if necessary
        // Artisan::call('db:seed', ['--database' => 'mongodb']);
    }

    public function tearDown(): void
    {
        // Drop the collections or perform any necessary cleanup
        $this->mongoClient->{$this->testDatabaseName}->collection1->drop();
        $this->mongoClient->{$this->testDatabaseName}->collection2->drop();

        // Rollback the migrations
        Artisan::call('migrate:reset', ['--database' => 'mongodb']);

        parent::tearDown();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {
        // Make a POST request to the register route with the necessary data
        $response = $this->post('api/register', [
            'name' => 'Fatahillah Karomy',
            'email' => 'fatahillah@karomy.com',
            'password' => 'password123',
        ]);

        // Assert that the response has a 201 status code
        $response->assertStatus(201);

        // Assert the structure of the JSON response
        $response->assertJsonStructure([
            'message'
        ]);
    }
    
    public function testEmailAlreadyExists()
    {
        // Make a POST request to the register route with the necessary data
        $this->post('api/register', [
            'name' => 'dummy',
            'email' => 'fatahillah@karomy.com',
            'password' => 'password123',
        ]);
        
        // Regiter again with the same Email Address
        $response = $this->post('api/register', [
            'name' => 'Fatahillah Karomy',
            'email' => 'fatahillah@karomy.com',
            'password' => 'password123',
        ]);
        
        // Assert that the response has a 422 status code
        $response->assertStatus(422);

        // Assert the structure of the JSON response
        $response->assertJsonStructure([
            'errors' => [
                "email",
            ]
        ]);
        
        //
    }

    public function testLogin()
    {
        // Register First
        $this->post('api/register', [
            'name' => 'Fatahillah Karomy',
            'email' => 'fatahillah@karomy.com',
            'password' => 'password123',
        ]);
        // Make a POST request to the login route with the user's credentials
        $response = $this->post('api/login', [
            'email' => 'fatahillah@karomy.com',
            'password' => 'password123',
        ]);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert the structure of the JSON response
        $response->assertJsonStructure([
            'token' 
        ]);
    }
    
    public function testInvalidLogin()
    {
        // Register First
        $this->post('api/register', [
            'name' => 'Fatahillah Karomy',
            'email' => 'fatahillah@karomy.com',
            'password' => 'password123',
        ]);
        // Make a POST request to the login route with the user's credentials
        $response = $this->post('api/login', [
            'email' => 'fatahillah@karomy.com',
            'password' => '232123221',
        ]);

        // Assert that the response has a 401 status code
        $response->assertStatus(401);

        // Assert the structure of the JSON response
        $response->assertJsonStructure([
            'message' 
        ]);
    }
}
