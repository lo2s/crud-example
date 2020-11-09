<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Http\Response;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    const BASE_PATH = '/api/employees';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);

        parent::__construct($name, $data, $dataName);
    }

    public function testIndex()
    {
        $employees = Employee::factory()->count(10)->create();

        $response = $this->get(self::BASE_PATH);

        $response->assertJson($employees->toArray())
            ->assertStatus(Response::HTTP_OK);
    }

    public function testShowWithExistedId()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(sprintf('%s/%d', self::BASE_PATH, $employee->id));

        $response->assertJson($employee->toArray())
            ->assertStatus(Response::HTTP_OK);
    }

    public function testShowWithWrongId()
    {
        $response = $this->get(sprintf('%s/%d', self::BASE_PATH, -1));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testStoreWithValidData()
    {
        $employeeData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'salary' => $this->faker->randomFloat(2),
        ];

        $response = $this->post(self::BASE_PATH, $employeeData);

        $response->assertJsonFragment($employeeData)
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testStoreWithInvalidData()
    {
        $response = $this->post(self::BASE_PATH, [
            'name' => Str::random(256),
            'email' => Str::random(),
            'salary' => Str::random(),
        ]);

        $response->assertJsonValidationErrors([
            'name' => 'The name may not be greater than 255 characters.',
            'email' => 'The email must be a valid email address.',
            'phone' => 'The phone field is required.',
            'salary' => 'The salary must be a number.',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUpdateWithExistedIdAndValidData()
    {
        $employee = Employee::factory()->create();

        $updatedData = [
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
        ];

        $response = $this->patch(sprintf('%s/%d', self::BASE_PATH, $employee->id), $updatedData);

        $response->assertJson(array_merge($employee->toArray(), $updatedData))
            ->assertStatus(Response::HTTP_OK);
    }

    public function testUpdateWithInvalidData()
    {
        $employee = Employee::factory()->create();

        $updatedData = [
            'phone' => Str::random(3),
            'email' => Str::random(),
        ];

        $response = $this->patch(sprintf('%s/%d', self::BASE_PATH, $employee->id), $updatedData);

        $response->assertJsonValidationErrors([
            'email' => 'The email must be a valid email address.',
            'phone' => 'The phone must be at least 10 characters.',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUpdateWithWrongId()
    {
        $response = $this->patch(sprintf('%s/%d', self::BASE_PATH, -1));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testDestroyWithExistedId()
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(sprintf('%s/%d', self::BASE_PATH, $employee->id));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testDestroyWithWrongId()
    {
        $response = $this->delete(sprintf('%s/%d', self::BASE_PATH, -1));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
