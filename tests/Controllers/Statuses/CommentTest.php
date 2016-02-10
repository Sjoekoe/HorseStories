<?php
namespace Controllers\Statuses;

use EQM\Events\CommentWasLiked;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CommentTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function it_can_create_a_comment()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id()
        ]);

        $this->actingAs($user)
            ->post('/statuses/' . $status->id() . '/comments', [
                'body' => 'Foo body'
            ])->assertResponseStatus(200);

        $this->seeInDatabase('comments', [
            'id' => 1,
            'body' => 'Foo body',
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);
    }

    /** @test */
    function it_can_like_a_comment()
    {
        $this->expectsEvents(CommentWasLiked::class);

        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create();
        $status = factory(EloquentStatus::class)->create([
            'horse_id' => $horse->id()
        ]);
        $comment = factory(EloquentComment::class)->create([
            'status_id' => $status->id(),
            'user_id' => $user->id(),
            'body' => 'Foo body',
        ]);

        $this->actingAs($user)
            ->post('/comments/' . $comment->id() . '/like', [])
            ->assertResponseStatus(200);

        $this->seeInDatabase('comment_likes', [
           'id'  => 1,
            'comment_id' => $comment->id(),
            'user_id' => $user->id(),
        ]);

        $this->actingAs($user)
            ->post('/comments/' . $comment->id() . '/like', [])
            ->assertResponseStatus(200);

        $this->notSeeInDatabase('comment_likes', [
            'id'  => 1,
            'comment_id' => $comment->id(),
            'user_id' => $user->id(),
        ]);
    }
}