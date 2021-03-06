<?php
namespace EQM\Core\Mailers;

use EQM\Models\Users\User;
use Illuminate\Mail\Mailer as Mail;

abstract class Mailer
{
    /**
     * @var \Illuminate\Mail\Mailer
     */
    protected $mail;

    /**
     * @param \Illuminate\Mail\Mailer $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param string $subject
     * @param string $view
     * @param array $data
     */
    public function sendTo(User $user, $subject, $view, $data = [])
    {
        $this->mail->queue($view, $data, function($message) use ($user, $subject) {
            $message->to($user->email())->subject($subject);
        });
    }
}
