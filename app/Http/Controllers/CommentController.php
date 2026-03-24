<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Services\ActivityLogService;
use App\Mail\NewCommentAdded;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Bug $bug)
    {
        $comment = $bug->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        ActivityLogService::log('comment_added', "Comment added on bug '{$bug->title}'.", $comment);

        // Notify reporter and assignee (if different from commenter)
        $recipients = collect();

        if ($bug->reporter && $bug->reporter_id !== auth()->id()) {
            $recipients->push($bug->reporter);
        }
        if ($bug->assignee && $bug->assigned_to !== auth()->id()) {
            $recipients->push($bug->assignee);
        }

        foreach ($recipients->unique('id') as $recipient) {
            Mail::to($recipient->email)->send(new NewCommentAdded($comment, $bug));
        }

        return redirect()->route('bugs.show', $bug)->with('success', 'Comment added successfully.');
    }
}
