<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()
            ->user()
            ->tasks()
            ->latest()
            ->paginate(5);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'min:3', 'max:255'],
                'description' => ['nullable', 'string'],
                'status' => ['required', 'in:pending,in_progress,completed'],
                'due_date' => ['nullable', 'date'],
                'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:2048'],
            ]);

            $attachmentPath = null;
            $attachmentOriginalName = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');

                $attachmentPath = $file->store('task-attachments', 'public');
                $attachmentOriginalName = $file->getClientOriginalName();
            }

            auth()->user()->tasks()->create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
                'due_date' => $validated['due_date'] ?? null,
                'attachment_path' => $attachmentPath,
                'attachment_original_name' => $attachmentOriginalName,
            ]);

            return redirect()
                ->route('tasks.index')
                ->with('success', 'Task added successfully.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Task could not be added. Please try again.');
        }
    }

    public function show(Task $task)
    {
        $this->authorizeTaskOwner($task);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorizeTaskOwner($task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTaskOwner($task);

        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'min:3', 'max:255'],
                'description' => ['nullable', 'string'],
                'status' => ['required', 'in:pending,in_progress,completed'],
                'due_date' => ['nullable', 'date'],
                'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:2048'],
            ]);

            $attachmentPath = $task->attachment_path;
            $attachmentOriginalName = $task->attachment_original_name;

            if ($request->hasFile('attachment')) {
                if ($task->attachment_path) {
                    Storage::disk('public')->delete($task->attachment_path);
                }

                $file = $request->file('attachment');

                $attachmentPath = $file->store('task-attachments', 'public');
                $attachmentOriginalName = $file->getClientOriginalName();
            }

            $task->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
                'due_date' => $validated['due_date'] ?? null,
                'attachment_path' => $attachmentPath,
                'attachment_original_name' => $attachmentOriginalName,
            ]);

            return redirect()
                ->route('tasks.index')
                ->with('success', 'Task updated successfully.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Task could not be updated. Please try again.');
        }
    }

    public function destroy(Task $task)
    {
        $this->authorizeTaskOwner($task);

        try {
            if ($task->attachment_path) {
                Storage::disk('public')->delete($task->attachment_path);
            }

            $task->delete();

            return redirect()
                ->route('tasks.index')
                ->with('success', 'Task deleted successfully.');
        } catch (Exception $e) {
            return back()
                ->with('error', 'Task could not be deleted. Please try again.');
        }
    }

    private function authorizeTaskOwner(Task $task): void
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}