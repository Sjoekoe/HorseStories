<?php
namespace EQM\Models\Comments;

use EQM\Models\Statuses\Status;
use Illuminate\Auth\AuthManager;

class CommentCreator
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param string $body
     * @return \EQM\Models\Comments\Comment
     */
    public function create(Status $status, $body)
    {
        $comment = new Comment();
        $comment->status_id = $status->id;
        $comment->body = $body;
        $comment->user_id = $this->auth->user()->id;

        $comment->save();

        return $comment;
    }
}
