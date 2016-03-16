<?php
namespace functional\Api;

use DB;
use EQM\Models\Notifications\Notification;

class NotificationsTest extends \TestCase
{
    /** @test */
    function it_can_get_all_notifications_for_a_user()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);

        DB::table('notifications')->insert([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
            'type' => Notification::STATUS_LIKED,
            'read' => false,
            'link' => 'www.test.com',
        ]);

        $this->actingAs($user)
            ->get('/api/notifications')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => 1,
                        'url' => 'http://localhost/notifications/1/show',
                        'type' => Notification::STATUS_LIKED,
                        'message' => 'John Doe has liked the status of test horse.',
                        'is_read' => false,
                        'receiver' => [
                            'data' => [
                                'id' => $user->id(),
                                'first_name' => $user->firstName(),
                                'last_name' => $user->lastName(),
                                'date_of_birth' => $user->dateOfBirth(),
                                'country' => $user->country(),
                                'email' => $user->email(),
                                'language' => $user->language(),
                                'gender' => $user->gender(),
                                'is_admin' => $user->isAdmin(),
                                'slug' => $user->slug(),
                            ],
                        ],
                        'sender' => [
                            'data' => [
                                'id' => $otherUser->id(),
                                'first_name' => $otherUser->firstName(),
                                'last_name' => $otherUser->lastName(),
                                'date_of_birth' => $otherUser->dateOfBirth(),
                                'country' => $otherUser->country(),
                                'email' => $otherUser->email(),
                                'language' => $otherUser->language(),
                                'gender' => $otherUser->gender(),
                                'is_admin' => $otherUser->isAdmin(),
                                'slug' => $otherUser->slug(),
                            ]
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_mark_all_notifications_as_read()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);

        DB::table('notifications')->insert([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
            'type' => Notification::STATUS_LIKED,
            'read' => false,
            'link' => 'www.test.com',
        ]);

        $this->actingAs($user)
            ->get('/api/notifications/mark-as-read')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => 1,
                        'url' => 'http://localhost/notifications/1/show',
                        'type' => Notification::STATUS_LIKED,
                        'message' => 'John Doe has liked the status of test horse.',
                        'is_read' => true,
                        'receiver' => [
                            'data' => [
                                'id' => $user->id(),
                                'first_name' => $user->firstName(),
                                'last_name' => $user->lastName(),
                                'date_of_birth' => $user->dateOfBirth(),
                                'country' => $user->country(),
                                'email' => $user->email(),
                                'language' => $user->language(),
                                'gender' => $user->gender(),
                                'is_admin' => $user->isAdmin(),
                                'slug' => $user->slug(),
                            ],
                        ],
                        'sender' => [
                            'data' => [
                                'id' => $otherUser->id(),
                                'first_name' => $otherUser->firstName(),
                                'last_name' => $otherUser->lastName(),
                                'date_of_birth' => $otherUser->dateOfBirth(),
                                'country' => $otherUser->country(),
                                'email' => $otherUser->email(),
                                'language' => $otherUser->language(),
                                'gender' => $otherUser->gender(),
                                'is_admin' => $otherUser->isAdmin(),
                                'slug' => $otherUser->slug(),
                            ]
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_delete_a_notification()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $otherUser = $this->createUser(['email' => 'test@test.com']);

        DB::table('notifications')->insert([
            'sender_id' => $otherUser->id(),
            'receiver_id' => $user->id(),
            'data' => json_encode([
                'sender' => $otherUser->fullName(),
                'horse' => $horse->name(),
            ]),
            'type' => Notification::STATUS_LIKED,
            'read' => false,
            'link' => 'www.test.com',
        ]);

        $this->actingAs($user)
            ->delete('api/notifications/1')
            ->assertResponseStatus(204);

        $this->missingFromDatabase('notifications', [
            'id' => 1,
        ]);
    }
}