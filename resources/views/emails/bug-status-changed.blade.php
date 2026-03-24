<!DOCTYPE html>
<html>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Bug Status Changed</h2>
    <p>The status of a bug has been updated:</p>
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
            <td style="padding: 8px; font-weight: bold;">Old Status:</td>
            <td style="padding: 8px;">{{ ucfirst(str_replace('_', ' ', $oldStatus)) }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">New Status:</td>
            <td style="padding: 8px;">{{ $bug->status_label }}</td>
        </tr>
    </table>
    <p>Please log in to the Bug Tracker to view full details.</p>
</body>

</html>
