<?php
namespace functional\Api;

use Carbon\Carbon;
use DB;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;

class StatusesTest extends \TestCase
{
    /** @test */
    function it_can_get_the_feed_for_a_user()
    {
        $now = Carbon::now();
        $user = factory(EloquentUser::class)->create([]);
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        DB::table('follows')->insert([
            'horse_id' => $horse->id(),
            'user_id' => $user->id(),
        ]);

        $this->get('/api/users/' . $user->id() . '/feed')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => $status->id(),
                        'body' => $status->body(),
                        'created_at' => $now->toIso8601String(),
                        'like_count' => 0,
                        'prefix' => $status->prefix(),
                        'horse' => [
                            'data' => [
                                'id' => $horse->id(),
                                'name' => $horse->name(),
                                'life_number' => $horse->lifeNumber(),
                                'breed' => $horse->breed,
                                'height' => $horse->height(),
                                'gender' => $horse->gender(),
                                'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                                'color' => $horse->color(),
                            ],
                        ],
                    ],
                ],
                'meta' => [
                    'pagination' => [
                        'count' => 1,
                        'current_page' => 1,
                        'links' => [],
                        'per_page' => 10,
                        'total' => 1,
                        'total_pages' => 1,
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_create_a_status()
    {
        $horse = $this->createHorse();

        $this->post('/api/statuses', [
            'horse_id' => $horse->id(),
            'body' => 'Foo',
        ])->seeJsonEquals([
            'data' => [
                'id' => 1,
                'body' => 'Foo',
                'created_at' => Carbon::now()->toIso8601String(),
                'like_count' => 0,
                'prefix' => null,
                'horse' => [
                    'data' => [
                        'id' => $horse->id(),
                        'name' => $horse->name(),
                        'life_number' => $horse->lifeNumber(),
                        'breed' => $horse->breed,
                        'height' => $horse->height(),
                        'gender' => $horse->gender(),
                        'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                        'color' => $horse->color(),
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    function it_can_show_a_status()
    {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->get('/api/statuses/' . $status->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'body' => $status->body(),
                    'created_at' => $status->createdAt()->toIso8601String(),
                    'like_count' => 0,
                    'prefix' => 1,
                    'horse' => [
                        'data' => [
                            'id' => $horse->id(),
                            'name' => $horse->name(),
                            'life_number' => $horse->lifeNumber(),
                            'breed' => $horse->breed,
                            'height' => $horse->height(),
                            'gender' => $horse->gender(),
                            'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                            'color' => $horse->color(),
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_show_a_status_with_the_likers()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->app->make('db')->table('likes')->insert([
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);

        $this->get('/api/statuses/' . $status->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => 1,
                    'body' => $status->body(),
                    'created_at' => $status->createdAt()->toIso8601String(),
                    'like_count' => 1,
                    'prefix' => 1,
                    'horse' => [
                        'data' => [
                            'id' => $horse->id(),
                            'name' => $horse->name(),
                            'life_number' => $horse->lifeNumber(),
                            'breed' => $horse->breed,
                            'height' => $horse->height(),
                            'gender' => $horse->gender(),
                            'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                            'color' => $horse->color(),
                        ],
                    ],
                    'likes' => [
                        'data' => [
                            [
                                'id' => $user->id(),
                                'first_name' => $user->firstName(),
                                'last_name' => $user->lastName(),
                                'email' => $user->email(),
                                'date_of_birth' => null,
                                'gender' => $user->gender(),
                                'country' => $user->country(),
                                'is_admin' => $user->isAdmin(),
                                'language' => $user->language(),
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_update_a_status()
    {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->put('/api/statuses/' . $status->id(), [
            'body' => 'Foo',
        ])->seeJsonEquals([
            'data' => [
                'id' => 1,
                'body' => 'Foo',
                'created_at' => $status->createdAt()->toIso8601String(),
                'like_count' => 0,
                'prefix' => 1,
                'horse' => [
                    'data' => [
                        'id' => $horse->id(),
                        'name' => $horse->name(),
                        'life_number' => $horse->lifeNumber(),
                        'breed' => $horse->breed,
                        'height' => $horse->height(),
                        'gender' => $horse->gender(),
                        'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                        'color' => $horse->color(),
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    function it_can_delete_a_status()
    {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->delete('/api/statuses/' . $status->id(), [])
            ->assertResponseStatus(204);

        $this->notSeeInDatabase('statuses', [
            'id' => $status->id(),
        ]);
    }
}
