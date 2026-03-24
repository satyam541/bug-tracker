<!DOCTYPE html>
<html>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Bug Assigned to You</h2>
    <p>A bug has been assigned to you:</p>
    <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <td style="padding: 8px; font-weight: bold;">Bug:</td>
            <td style="padding: 8px;">{{ $bug->title }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Project:</td>
            <td style="padding: 8px;">{{ $bug->project->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Priority:</td>
            <td style="padding: 8px;">{{ ucfirst($bug->priority) }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Severity:</td>
            <td style="padding: 8px;">{{ ucfirst($bug->severity) }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Reported By:</td>
            <td style="padding: 8px;">{{ $bug->reporter->name }}</td>
        </tr>
    </table>
    <p>{{ $bug->description }}</p>
    <p>Please log in to the Bug Tracker to view full details.</p>
</body>

</html>
