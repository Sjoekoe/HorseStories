<?php
namespace functional\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class HorsesTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_show_a_horse()
    {
        $horse = $this->createHorse();

        $this->get('api/horses/' . $horse->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => $horse->id(),
                    'name' => $horse->name(),
                    'life_number' => $horse->lifeNumber(),
                    'breed' => $horse->breed,
                    'height' => $horse->height(),
                    'gender' => $horse->gender(),
                    'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                    'color' => $horse->color(),
                    'slug' => $horse->slug(),
                    'is_followed_by_user' => false,
                    'profile_picture' =>  'http://localhost/images/eqm.png',
                ],
            ]);
    }

    /** @test */
    function it_can_show_a_horse_with_statuses()
    {
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->get('api/horses/' . $horse->id(). '?include=statuses')
            ->seeJsonEquals([
                'data' => [
                    'id' => $horse->id(),
                    'name' => $horse->name(),
                    'life_number' => $horse->lifeNumber(),
                    'breed' => $horse->breed,
                    'height' => $horse->height(),
                    'gender' => $horse->gender(),
                    'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                    'color' => $horse->color(),
                    'slug' => $horse->slug(),
                    'is_followed_by_user' => false,
                    'profile_picture' =>  'http://localhost/images/eqm.png',
                    'statuses' => [
                        'data' => [
                            [
                                'id' => $status->id(),
                                'body' => $status->body(),
                                'created_at' => $status->createdAt()->toIso8601String(),
                                'prefix' => trans('statuses.prefixes.' . $status->prefix()),
                                'like_count' => 0,
                                'liked_by_user' => false,
                                'can_delete_status' => false,
                                'is_horse_status' => true,
                                'comments' => [
                                    'data' => []
                                ],
                                'poster' => [
                                    'data' => [
                                        'id' => $horse->id(),
                                        'name' => $horse->name(),
                                        'life_number' => $horse->lifeNumber(),
                                        'breed' => $horse->breed,
                                        'height' => $horse->height(),
                                        'gender' => $horse->gender(),
                                        'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
                                        'color' => $horse->color(),
                                        'slug' => $horse->slug(),
                                        'is_followed_by_user' => false,
                                        'profile_picture' =>  'http://localhost/images/eqm.png',
                                    ],
                                ],
                                'picture' => null,
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
