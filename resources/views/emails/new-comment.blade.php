<!DOCTYPE html>
<html>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>New Comment on Bug</h2>
    <p>A new comment has been added:</p>
    <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <td style="padding: 8px; font-weight: bold;">Bug:</td>
            <td style="padding: 8px;">{{ $bug->title }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Comment By:</td>
            <td style="padding: 8px;">{{ $comment->user->name }}</td>
        </tr>
    </table>
    <blockquote style="border-left: 3px solid #ccc; padding-left: 10px; margin: 15px 0; color: #555;">
        {{ $comment->body }}
    </blockquote>
    <p>Please log in to the Bug Tracker to view full details.</p>
</body>

</html>
