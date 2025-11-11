<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCompletedNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Task Marked as Completed')
                    ->line("Your task '{$this->task->title}' has been marked as completed.")
                    ->action('View Task', route('tasks.index'))
                    ->line('Thank you for using our task management system!');
    }
}