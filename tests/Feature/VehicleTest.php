<?php

namespace Tests\Feature;

use SebastianBergmann\Type\VoidType;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use MongoDB\Client;

class VehicleTest extends TestCase
{
    
    protected $mongoClient;
    protected $testDatabaseName = 'db_vehicles_test';
    
    public function getToken(): string
    {
        $this->post('api/register', [
            'name' => 'dummy',
            'email' => 'fatahillah@karomy.com',
            'password' => 'password123',
        ]);
        
        // Regiter again with the same Email Address
        $res = $this->post('api/login', [
            'name' => 'Fatahillah Karomy',
            'email' => 'fatahillah@karomy.com',
            'password' => 'password123',
        ]);
        
        $response = $res->json();
        return $response['token'];
    }
    
    public function createCar(): string
    {
        $accessToken = $this->getToken();

        $response = $this->postJson('api/cars', [
            'tahun_keluaran' => 2010,
            'warna' => 'kuning',
            'harga' => 100000,
            'stok' => 5,
            "detail" => [
                "mesin" =>  'dummy',
                'kapasitas_penumpang' => 5,
                'tipe' => 'dummy',
            ]
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);
        
        $data = $response->json()['data'];
        $carId = $data['_id'];
        
        return $carId;
    }
    
    public function createMotor(): string
    {
        $accessToken = $this->getToken();

        $response = $this->postJson('api/motors', [
            'tahun_keluaran' => 2010,
            'warna' => 'kuning',
            'harga' => 100000,
            'stok' => 5,
            "detail" => [
                "mesin" =>  'dummy',
                'tipe_suspensi' => 'dummy',
                'tipe_transmisi' => 'dummy',
            ]
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);
        
        $data = $response->json()['data'];
        $motorId = $data['_id'];
        
        return $motorId;
    }
    
    public function createSalesMotor(): string
    {
        $accessToken = $this->getToken();
        // Get Id
        $idMotor = $this->createMotor();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->postJson('api/sales/', [
            'nama_customer' => 'Fatahillah',
            'jumlah' => 1,
            'tipe' => 'Motor',
            'item_id' => $idMotor,
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);
        
        $data = $response->json()['data'];
        $salesId = $data['_id'];
        
        return $salesId;
    }
    
    public function createSalesCar(): string
    {
        $accessToken = $this->getToken();
        // Get Id
        $idCar = $this->createCar();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->postJson('api/sales/', [
            'nama_customer' => 'Fatahillah',
            'jumlah' => 1,
            'tipe' => 'Mobil',
            'item_id' => $idCar,
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);
        
        $data = $response->json()['data'];
        $salesId = $data['_id'];
        
        return $salesId;
    }

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
    public function testCreateCar()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();

        // Create a new car by making a request to the appropriate endpoint with the access token
        $response = $this->postJson('api/cars', [
            'tahun_keluaran' => 2010,
            'warna' => 'kuning',
            'harga' => 100000,
            'stok' => 5,
            "detail" => [
                "mesin" =>  'dummy',
                'kapasitas_penumpang' => 5,
                'tipe' => 'dummy',
            ]
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(201);
        
        $response->assertJsonStructure([
            'data' => [
                'tahun_keluaran',
                'warna',
                'harga',
                'tipe',
                'stok',
                'detail' => [
                    'mesin',
                    'kapasitas_penumpang',
                    'tipe'
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testFindCarAll()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id Car 
        $this->createCar();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->getJson('api/cars/', [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                [
                    'tahun_keluaran',
                    'warna',
                    'harga',
                    'tipe',
                    'stok',
                    'detail' => [
                        'mesin',
                        'kapasitas_penumpang',
                        'tipe'
                    ],
                    'updated_at',
                    'created_at',
                    '_id',
                ]
            ]
        ]);
    }
    
    public function testFindCarById()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id Car 
        $idCar = $this->createCar();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->getJson('api/cars/'. $idCar, [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                'tahun_keluaran',
                'warna',
                'harga',
                'tipe',
                'stok',
                'detail' => [
                    'mesin',
                    'kapasitas_penumpang',
                    'tipe'
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testUpdateCar()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id Car 
        $idCar = $this->createCar();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->putJson('api/cars/' . $idCar, [
            'tahun_keluaran' => 2011,
            'warna' => 'merah',
            'harga' => 100000,
            'stok' => 5,
            "detail" => [
                "mesin" =>  'dummy',
                'kapasitas_penumpang' => 5,
                'tipe' => 'dummy',
            ]
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                'tahun_keluaran',
                'warna',
                'harga',
                'tipe',
                'stok',
                'detail' => [
                    'mesin',
                    'kapasitas_penumpang',
                    'tipe'
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testDeleteCar()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id Car 
        $idCar = $this->createCar();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->deleteJson('api/cars/' . $idCar, [] ,[
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'message'
        ]);
    }
    
    public function testCreateMotor()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();

        // Create a new car by making a request to the appropriate endpoint with the access token
        $response = $this->postJson('api/motors', [
            'tahun_keluaran' => 2010,
            'warna' => 'kuning',
            'harga' => 100000,
            'stok' => 5,
            "detail" => [
                'mesin' =>  'dummy',
                'tipe_suspensi' => 'dummy',
                'tipe_transmisi' => 'dummy',
            ]
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(201);
        
        $response->assertJsonStructure([
            'data' => [
                'tahun_keluaran',
                'warna',
                'harga',
                'tipe',
                'stok',
                'detail' => [
                    'mesin',
                    'tipe_suspensi',
                    'tipe_transmisi'
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testFindMotorAll()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id Motor 
        $this->createMotor();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->getJson('api/motors/', [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                [
                    'tahun_keluaran',
                    'warna',
                    'harga',
                    'tipe',
                    'stok',
                    'detail' => [
                        'mesin',
                        'tipe_suspensi',
                        'tipe_transmisi'
                    ],
                    'updated_at',
                    'created_at',
                    '_id',
                ]
            ]
        ]);
    }
    
    public function testFindMotorById()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id Motor 
        $idMotor = $this->createMotor();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->getJson('api/motors/'. $idMotor, [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                'tahun_keluaran',
                'warna',
                'harga',
                'tipe',
                'stok',
                'detail' => [
                    'mesin',
                    'tipe_suspensi',
                    'tipe_transmisi'
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testUpdateMotor()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id Motor 
        $idMotor = $this->createMotor();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->putJson('api/motors/' . $idMotor, [
            'tahun_keluaran' => 2011,
            'warna' => 'kuning',
            'harga' => 10000,
            'stok' => 10,
            'detail' => [
                'mesin' => 'dummy',
                'tipe_suspensi' => 'dummy',
                'tipe_transmisi' => 'dummy',
            ],
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                'tahun_keluaran',
                'warna',
                'harga',
                'tipe',
                'stok',
                'detail' => [
                    'mesin',
                    'tipe_suspensi',
                    'tipe_transmisi',
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testDeleteMotor()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id Motor 
        $idMotor = $this->createMotor();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->deleteJson('api/motors/' . $idMotor, [] ,[
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'message'
        ]);
    }
    
    public function testCreateSalesMotor()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id
        $idMotor = $this->createMotor();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->postJson('api/sales/', [
            'nama_customer' => 'Fatahillah',
            'jumlah' => 1,
            'tipe' => 'Motor',
            'item_id' => $idMotor,
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(201);
        
        $response->assertJsonStructure([
            'data' => [
                'nama_customer',
                'jumlah',
                'total_harga',
                'jenis_kendaraan',
                'item' => [
                    'tahun_keluaran',
                    'warna',
                    'harga',
                    'detail' => [
                        'mesin',
                        'tipe_suspensi',
                        'tipe_transmisi',
                    ],
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testCreateSalesCar()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id
        $idCar = $this->createCar();

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->postJson('api/sales/', [
            'nama_customer' => 'Fatahillah',
            'jumlah' => 1,
            'tipe' => 'Mobil',
            'item_id' => $idCar,
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(201);
        
        $response->assertJsonStructure([
            'data' => [
                'nama_customer',
                'jumlah',
                'total_harga',
                'jenis_kendaraan',
                'item' => [
                    'tahun_keluaran',
                    'warna',
                    'harga',
                    'detail' => [
                        'mesin',
                        'kapasitas_penumpang',
                        'tipe'
                    ],
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testFindSalesAll()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        
        $this->createSalesMotor();
        $this->createSalesCar();
               

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->getJson('api/sales/', [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                [
                    'nama_customer',
                    'jumlah',
                    'total_harga',
                    'jenis_kendaraan',
                    'item',
                    'updated_at',
                    'created_at',
                    '_id',   
                ]
            ]
        ]);
    }
    
    public function testFindSalesCarById()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id
        $idSales = $this->createSalesCar();
        

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->getJson('api/sales/' . $idSales, [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                'nama_customer',
                'jumlah',
                'total_harga',
                'jenis_kendaraan',
                'item' => [
                    'tahun_keluaran',
                    'warna',
                    'harga',
                    'detail' => [
                        'mesin',
                        'kapasitas_penumpang',
                        'tipe'
                    ],
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
    
    public function testFindSalesMotorById()
    {
        // Generate an access token for authentication
        $accessToken = $this->getToken();
        // Get Id
        $idSales = $this->createSalesMotor();
        

        // Create a new vehicle by making a request to the appropriate endpoint with the access token
        $response = $this->getJson('api/sales/' . $idSales, [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        // Assert the response
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                'nama_customer',
                'jumlah',
                'total_harga',
                'jenis_kendaraan',
                'item' => [
                    'tahun_keluaran',
                    'warna',
                    'harga',
                    'detail' => [
                        'mesin',
                        'tipe_suspensi',
                        'tipe_transmisi',
                    ],
                ],
                'updated_at',
                'created_at',
                '_id',
            ]
        ]);
    }
}
