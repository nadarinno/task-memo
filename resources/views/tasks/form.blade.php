<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if($method === 'PUT')
        @method('PUT')
    @endif

    <label>Title</label>
    <input
        type="text"
        name="title"
        value="{{ old('title', $task->title ?? '') }}"
        required
    >

    <label>Description</label>
    <textarea name="description" rows="5">{{ old('description', $task->description ?? '') }}</textarea>

    <label>Status</label>
    <select name="status" required>
        <option value="pending" {{ old('status', $task->status ?? '') === 'pending' ? 'selected' : '' }}>
            Pending
        </option>

        <option value="in_progress" {{ old('status', $task->status ?? '') === 'in_progress' ? 'selected' : '' }}>
            In Progress
        </option>

        <option value="completed" {{ old('status', $task->status ?? '') === 'completed' ? 'selected' : '' }}>
            Completed
        </option>
    </select>

    <label>Due Date</label>
    <input
        type="date"
        name="due_date"
        value="{{ old('due_date', $task && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
    >

    <label>Attachment</label>
    <input type="file" name="attachment">

    @if($task && $task->attachment_path)
        <p>
            Current attachment:
            <a href="{{ asset('storage/' . $task->attachment_path) }}" target="_blank">
                {{ $task->attachment_original_name }}
            </a>
        </p>
    @endif

    <button type="submit">
        {{ $method === 'PUT' ? 'Update Task' : 'Add Task' }}
    </button>

    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
</form>