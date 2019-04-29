<?php

namespace Tests\Feature\Rules;

use App\Models\Beacon;
use App\Models\Container;
use App\Models\Rule;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RulesDeleteTest extends TestCase
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
    public function a_guest_cannot_delete_rules()
    {
        $this->deleteJson(route('rules.destroy', [
            'container' => $this->container,
            'beacon' => $this->beacon,
            'rule' => $this->rule
        ]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_rules()
    {
        $this->signIn();

        $this->deleteJson(route('rules.destroy', [
            'container' => $this->container,
            'beacon' => $this->beacon,
            'rule' => $this->rule
        ]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_rules()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.delete'])
        );

        $this->deleteJson(route('rules.destroy', [
            'container' => $this->container,
            'beacon' => $this->beacon,
            'rule' => $this->rule
        ]))->assertOk();

        $this->assertDatabaseMissing('rules', ['id' => $this->rule->id]);
    }
}
