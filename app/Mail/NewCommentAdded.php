<?php

namespace App\Mail;

use App\Models\Bug;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCommentAdded extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Comment $comment, public Bug $bug) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Comment on Bug: {$this->bug->title}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-comment',
        );
    }
}
