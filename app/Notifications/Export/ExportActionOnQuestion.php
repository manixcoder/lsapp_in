<?php

namespace App\Notifications\Export;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExportActionOnQuestion extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification_data)
    {
        //dd($notification_data);
        $this->details = $notification_data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
        // return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //dd($notifiable);
        return (new MailMessage)
            ->subject('You\'ve Receive a new Question')
            ->greeting('Hi ' . $this->details['user'])
            //->line('Hi ' . $this->details['user'])
            ->line($this->details['message'])
            ->action('account dashboard', url('/dashboard'))
            // ->action('Buttons1', url('/button1url'))
            // ->action('Button2', url('/button2url'))
            ->line('To turn off these email notifications,you may do so in your account settings.');
    }

    // public function toDatabase($notifiable)
    // {
    //     //dd($notifiable);
    //     return [
    //         // 'admin' => $this->details['user'],
    //         'message' => $this->details['message'],
    //         'action' => $this->details['action'],
    //     ];
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
