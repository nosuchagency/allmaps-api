<?php

namespace Tests\Feature\Hits;

use App\Models\Hit;
use App\Pivots\BeaconContainer;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HitsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_hits()
    {
        $this->postJson(route('hits.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_hits()
    {
        $this->signIn();

        $this->postJson(route('hits.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_hits()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Hit::all());
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['hits.create'])
        );

        return $this->postJson(route('hits.store'), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'type' => 'beacon_container',
            'model' => factory(BeaconContainer::class)->create()
        ], $overrides);
    }
}
