<?php

namespace App\Mail;

use App\Models\Bug;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BugStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Bug $bug, public string $oldStatus) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Bug Status Changed: {$this->bug->title}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bug-status-changed',
        );
    }
}
