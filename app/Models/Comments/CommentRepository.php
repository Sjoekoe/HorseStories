<?php
namespace EQM\Models\Comments;

use EQM\Models\Statuses\Status;
use EQM\Models\Users\User;

interface CommentRepository
{
    /**
     * @param int $id
     * @return \EQM\Models\Comments\Comment
     */
    public function findById($id);

    public function findForStatusPaginated(Status $status, $limit = 10);

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param \EQM\Models\Users\User $user
     * @param string $body
     * @return \EQM\Models\Comments\Comment
     */
    public function create(Status $status, User $user, $body);

    /**
     * @param \EQM\Models\Comments\Comment $comment
     * @param string $body
     * @return \EQM\Models\Comments\Comment
     */
    public function update(Comment $comment, $body);

    /**
     * @param \EQM\Models\Comments\Comment $comment
     */
    public function delete(Comment $comment);

    /**
     * @return int
     */
    public function count();
}
