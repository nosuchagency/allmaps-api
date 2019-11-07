<?php

namespace Tests\Feature\Rules;

use App\Models\Beacon;
use App\Models\Container;
use App\Models\Rule;
use App\Weekday;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RulesCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $container;

    protected $beacon;

    public function setUp(): void
    {
        parent::setUp();

        $this->container = factory(Container::class)->create();
        $this->beacon = factory(Beacon::class)->create();
        $this->container->beacons()->attach($this->beacon);
    }

    /** @test */
    public function a_guest_cannot_create_rules()
    {
        $this->postJson(route('rules.store', [
            'container' => $this->container,
            'beacon' => $this->beacon
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_rules()
    {
        $this->signIn();

        $this->postJson(route('rules.store', [
            'container' => $this->container,
            'beacon' => $this->beacon
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_rules()
    {
        $this->withoutExceptionHandling();

        $this->create()->assertStatus(201);
        $this->assertCount(1, Rule::all());
    }

    /** @test */
    public function distance_is_required_and_has_to_be_of_valid_value()
    {
        $this->create(['distance' => null])->assertJsonValidationErrors('distance');
        $this->create(['distance' => 'not-a-valid-distance'])->assertJsonValidationErrors('distance');
    }

    /** @test */
    public function weekday_is_required_and_has_to_be_of_valid_value()
    {
        $this->create(['weekday' => null])->assertJsonValidationErrors('weekday');
        $this->create(['weekday' => 'not-a-valid-weekday'])->assertJsonValidationErrors('weekday');
    }

    /** @test */
    public function time_restricted_needs_to_be_a_boolean()
    {
        $this->create(['time_restricted' => 'not-a-valid_boolean'])->assertJsonValidationErrors('time_restricted');
    }

    /** @test */
    public function date_restricted_needs_to_be_a_boolean()
    {
        $this->create(['time_restricted' => 'not-a-valid-boolean'])->assertJsonValidationErrors('time_restricted');
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $role = $this->createRoleWithPermissions(['rule:create']);

        $this->signIn(null, $role);

        return $this->postJson(route('rules.store', [
            'container' => $this->container,
            'beacon' => $this->beacon
        ]), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'distance' => $this->faker->randomElement(['close', 'medium', 'far']),
            'weekday' => $this->faker->randomElement(Weekday::WEEKDAYS),
            'time_restricted' => $this->faker->boolean,
            'date_restricted' => $this->faker->boolean,
            'time_from' => now()->format('H:i'),
            'time_to' => now()->addHour()->format('H:i'),
            'date_from' => now()->format('Y-m-d'),
            'date_to' => now()->addDay()->format('Y-m-d')
        ], $overrides);
    }
}
