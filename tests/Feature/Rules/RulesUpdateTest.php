<?php

namespace Tests\Feature\Rules;

use App\Distance;
use App\Models\Beacon;
use App\Models\Container;
use App\Models\Rule;
use App\Weekday;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RulesUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $container;

    protected $beacon;

    protected $rule;

    public function setUp(): void
    {
        parent::setUp();

        $this->container = factory(Container::class)->create();
        $this->beacon = factory(Beacon::class)->create();
        $this->container->beacons()->attach($this->beacon);

        $beacon = $this->container->beacons()->findOrFail($this->beacon->id);

        $this->rule = $beacon->pivot->rules()->save(
            factory(Rule::class)->create([
                'beacon_container_id' => $beacon->pivot->id
            ])
        );
    }

    /** @test */
    public function a_guest_cannot_update_rules()
    {
        $this->putJson(route('rules.update', [
            'container' => $this->container,
            'beacon' => $this->beacon,
            'rule' => $this->rule
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_rules()
    {
        $this->signIn();

        $this->putJson(route('rules.update', [
            'container' => $this->container,
            'beacon' => $this->beacon,
            'rule' => $this->rule
        ]))->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_update_beacons()
    {
        $attributes = ['id' => $this->rule->id, 'date_from' => now()->format('Y-m-d')];

        $this->update($this->rule, $attributes)->assertOk();

        $this->assertDatabaseHas('rules', $attributes);
    }

    /**
     * @param $rule
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($rule, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.update', 'containers.update'])
        );

        return $this->putJson(route('rules.update', [
                'container' => $this->container,
                'beacon' => $this->beacon,
                'rule' => $rule
            ]
        ), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'distance' => $this->faker->randomElement(Distance::DISTANCES),
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
