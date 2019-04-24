<?php

namespace Tests\Feature\Beacons;

use App\Models\Beacon;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_beacons()
    {
        $this->postJson(route('beacons.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_beacons()
    {
        $this->signIn();

        $this->postJson(route('beacons.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_beacons()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Beacon::all());
    }

    /** @test */
    public function name_is_required()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function major_needs_to_be_an_integer_between_0_and_65535()
    {
        $this->create(['major' => 'not-a-valid-major'])->assertJsonValidationErrors(['major']);
        $this->create(['major' => -1])->assertJsonValidationErrors(['major']);
        $this->create(['major' => 65536])->assertJsonValidationErrors(['major']);
    }

    /** @test */
    public function minor_needs_to_be_an_integer_between_0_and_65535()
    {
        $this->create(['minor' => 'not-a-valid-major'])->assertJsonValidationErrors(['minor']);
        $this->create(['minor' => -1])->assertJsonValidationErrors(['minor']);
        $this->create(['minor' => 65536])->assertJsonValidationErrors(['minor']);
    }

    /** @test */
    public function proximity_uuid_needs_to_be_a_valid_uuid()
    {
        $this->create(['proximity_uuid' => 'not-a-valid-uuid'])->assertJsonValidationErrors(['proximity_uuid']);
    }

    /** @test */
    public function eddystone_uid_needs_to_be_a_valid_uuid()
    {
        $this->create(['eddystone_uid' => 'not-a-valid-uuid'])->assertJsonValidationErrors(['eddystone_uid']);
    }

    /** @test */
    public function eddystone_url_needs_to_be_a_valid_url()
    {
        $this->create(['eddystone_url' => 'not-a-valid-url'])->assertJsonValidationErrors(['eddystone_url']);
    }

    /** @test */
    public function category_needs_to_be_a_valid_category_object()
    {
        $this->create(['category' => ['id' => 2]])->assertJsonValidationErrors(['category.id']);
        $this->create(['category' => []])->assertJsonValidationErrors(['category']);
    }

    /** @test */
    public function tags_needs_to_be_an_array_of_valid_tag_objects()
    {
        $this->create(['tags' => 'not-a-valid-tags-array'])->assertJsonValidationErrors(['tags']);
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.create'])
        );

        return $this->postJson(route('beacons.store'), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'name' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'proximity_uuid' => $this->faker->uuid,
            'major' => $this->faker->numberBetween(0, 65535),
            'minor' => $this->faker->numberBetween(0, 65535),
            'eddystone_uid' => $this->faker->uuid,
            'eddystone_url' => $this->faker->url,
            'eddystone_tlm' => $this->faker->title,
            'eddystone_eid' => $this->faker->title,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
