<?php

namespace Tests\Feature;

use App\Enums\Client\ClientStatusEnum;
use App\Enums\Client\EmlpoyeeCountEnum;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();

        $user = User::find(1);
        Sanctum::actingAs($user, ['access-token']);
    }

    /**
     * Summary of test_client_can_get_all
     * @return void
     */
    public function test_client_can_get_all(): void
    {
        $response = $this->getJson("/api/v1/clients");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'items' => [
                        [
                            "name",
                            "leader",
                            "address",
                            "status",
                            "contact_person",
                            "contacts",
                            "user_id",
                            "created_at",
                            "updated_at"
                        ]
                    ],
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'last_page',
                        'total'
                    ]
                ]
            ]);
    }

    /**
     * Summary of test_client_can_show
     * @return void
     */
    public function test_client_can_show(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $clientId = Client::inRandomOrder()->first()->id;

        $response = $this->getJson('/api/v1/clients/' . $clientId);

        $response
            ->assertStatus(200);
    }

    /**
     * Summary of test_client_can_create
     * @return void
     */
    public function test_client_can_create(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $name = "Artel";
        $status = "Potential";
        $leader = "Donald Trump";
        $contactPerson = "Joe Biden";
        $personPosition = "Director";
        $personPhone = "1233344322";
        $personEmail = "joe@yandex.ru";
        $phone = "998974563241";
        $email = "biden@mail.ru";
        $address = "USA New York";
        $INN = "23454356";
        $employeeCount = "-50";
        $source = "hh.uz";
        $activity = "Programming";
        $description = "description";
        $notes = "notes";
        $userId = User::inRandomOrder()->first()->id;

        $data = [
            'name' => $name,
            'status' => $status,
            'leader' => $leader,
            'contact_person' => $contactPerson,
            'person_position' => $personPosition,
            'person_phone' => $personPhone,
            'person_email' => $personEmail,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'user_id' => $userId,
            'INN' => $INN,
            'employee_count' => $employeeCount,
            'source' => $source,
            'activity' => $activity,
            'description' => $description,
            'notes' => $notes,
        ];

        $response = $this->postJson('/api/v1/clients/create', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('clients', [
            'name' => $name,
            'status' => $status,
            'leader' => $leader,
            'contact_person' => $contactPerson,
            'person_position' => $personPosition,
            'person_phone' => $personPhone,
            'person_email' => $personEmail,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'user_id' => $userId,
            'INN' => $INN,
            'employee_count' => $employeeCount,
            'source' => $source,
            'activity' => $activity,
            'description' => $description,
            'notes' => $notes,
        ]);
    }

    /**
     * Summary of test_client_can_update
     * @return void
     */
    public function test_client_can_update(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $client = Client::inRandomOrder()->first();

        $name = "Asus";
        $status = ClientStatusEnum::ACTIVE;
        $leader = "Vladimir Putin";
        $contactPerson = "Vladimir Zelenskiy";
        $personPosition = "President";
        $personPhone = "43565753423";
        $personEmail = "vlad@yandex.ru";
        $phone = "998974563212";
        $email = "vladimir@mail.ru";
        $address = "Russia Moscow";
        $INN = "456323344";
        $employeeCount = EmlpoyeeCountEnum::SMALL->value;
        $source = "ish.uz";
        $activity = "Politics";
        $description = "new description";
        $notes = "new notes";
        $userId = User::inRandomOrder()->first()->id;

        $data = [
            'name' => $name,
            'status' => $status,
            'leader' => $leader,
            'contact_person' => $contactPerson,
            'person_position' => $personPosition,
            'person_phone' => $personPhone,
            'person_email' => $personEmail,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'user_id' => $userId,
            'INN' => $INN,
            'employee_count' => $employeeCount,
            'source' => $source,
            'activity' => $activity,
            'description' => $description,
            'notes' => $notes,
        ];

        $response = $this->putJson('/api/v1/clients/update/' . $client->id, $data);

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas('clients', [
            'name' => $name,
            'status' => $status,
            'leader' => $leader,
            'contact_person' => $contactPerson,
            'person_position' => $personPosition,
            'person_phone' => $personPhone,
            'person_email' => $personEmail,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'user_id' => $userId,
            'INN' => $INN,
            'employee_count' => $employeeCount,
            'source' => $source,
            'activity' => $activity,
            'description' => $description,
            'notes' => $notes,
        ]);
    }

    /**
     * Summary of test_client_can_delete
     * @return void
     */
    public function test_client_can_delete(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $clientId = Client::inRandomOrder()->first()->id;

        $response = $this->deleteJson('/api/v1/clients/delete/' . $clientId);

        $response
            ->assertStatus(200);

        $this->assertSoftDeleted('clients', [
            'id' => $clientId,
        ]);
    }

    /**
     * Summary of test_upload_file_to_client
     * @return void
     */
    public function test_upload_file_to_client(): void
    {
        $client = Client::inRandomOrder()->first();

        $file = UploadedFile::fake()->create(
            'INN.pdf',
            200, // 200 KB
            'application/pdf'
        );

        $payload = [
            'files' => [$file],
        ];

        $response = $this->postJson("api/v1/clients/$client->id/files/upload", $payload);

        $response->assertStatus(200);
    }

    /**
     * Summary of test_delete_file_in_client
     * @return void
     */
    public function test_delete_file_in_client(): void
    {
        $client = Client::inRandomOrder()->first();

        $file = UploadedFile::fake()->create(
            'document.pdf',
            200, // 200 KB
            'application/pdf'
        );
        $payload = [
            'files' => [$file],
        ];

        $fileId = $client->files()->inRandomOrder()->first()->id;

        $response = $this->deleteJson("/api/v1/clients/$client->id/files/deleteFile/$fileId");

        $response->assertStatus(200);

        $this->assertSoftDeleted('files', [
            'id' => $fileId,
        ]);
    }
}
