<?php

namespace Tests\Feature\Rules;

use App\Models\Beacon;
use App\Models\Container;
use App\Models\Rule;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RulesReadTest extends TestCase
{
    use RefreshDatabase;

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
    public function a_guest_cannot_read_rules()
    {
        $this->getJson(route('rules.show', [
            'beacon' => $this->beacon,
            'container' => $this->container,
            'rule' => $this->rule
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_read_rules()
    {
        $this->signIn();

        $this->getJson(route('rules.show', [
            'beacon' => $this->beacon,
            'container' => $this->container,
            'rule' => $this->rule
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_read_rules()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.read', 'containers.read'])
        );

        $this->getJson(route('rules.show', [
            'beacon' => $this->beacon,
            'container' => $this->container,
            'rule' => $this->rule
        ]))->assertOk();
    }
}
