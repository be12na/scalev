<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PesanWhatsApp extends Notification
{

    use Queueable;

    public $content;
   
    public function __construct(array $payload)
    {
        $this->content = $payload['content'];
    }

    public function via($notifiable)
    {
        return ['onesender'];
    }
}
