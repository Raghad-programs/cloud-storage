<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FileUploaded extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for the database.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }
}
