<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBugRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Controller handles role-based logic
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'project_id' => ['required', 'exists:projects,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:open,in_progress,fixed,closed'],
            'priority' => ['required', 'in:low,medium,high,critical'],
            'severity' => ['required', 'in:minor,major,critical'],
            'screenshot' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}
