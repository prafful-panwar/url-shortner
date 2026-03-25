<?php

namespace App\Notifications;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class InvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Invitation $invitation
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = URL::route('invitations.accept', ['token' => $this->invitation->token]);

        /** @var User $inviter */
        $inviter = $this->invitation->inviter;

        return (new MailMessage)
            ->subject('You have been invited to join '.config('app.name'))
            ->line('You have been invited to join our platform by '.$inviter->name.'.')
            ->action('Accept Invitation', $url)
            ->line('This invitation link will expire in 7 days.')
            ->line('Thank you for using our application!');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        /** @var Company $company */
        $company = $this->invitation->company;

        return [
            'invitation_id' => $this->invitation->id,
            'company_name' => $company->name,
        ];
    }
}
