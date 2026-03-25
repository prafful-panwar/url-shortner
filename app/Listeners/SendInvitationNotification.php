<?php

namespace App\Listeners;

use App\Events\InvitationCreated;
use App\Notifications\InvitationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvitationNotification implements ShouldQueue
{
    public function handle(InvitationCreated $event): void
    {
        $event->invitation->notify(new InvitationNotification($event->invitation));
    }
}
