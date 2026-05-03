{{-- Title --}}
<div class="mb-3">
    <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $task->title ?? '') }}" placeholder="e.g. Complete Lab Report">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Description --}}
<div class="mb-3">
    <label for="description" class="form-label fw-semibold">Description</label>
    <textarea id="description" name="description" rows="3"
              class="form-control @error('description') is-invalid @enderror"
              placeholder="Optional details about the task…">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Subject --}}
<div class="mb-3">
    <label for="subject" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
    <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror"
           value="{{ old('subject', $task->subject ?? '') }}" placeholder="e.g. Web Programming">
    @error('subject')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    {{-- Status --}}
    <div class="col-md-4 mb-3">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
            <option value="0" @selected((int) old('status', $task->status ?? 0) === 0)>Pending</option>
            <option value="1" @selected((int) old('status', $task->status ?? 0) === 1)>Done</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Priority --}}
    <div class="col-md-4 mb-3">
        <label for="priority" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
        <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror">
            <option value="0" @selected((int) old('priority', $task->priority ?? 1) === 0)>Low</option>
            <option value="1" @selected((int) old('priority', $task->priority ?? 1) === 1)>Medium</option>
            <option value="2" @selected((int) old('priority', $task->priority ?? 1) === 2)>High</option>
        </select>
        @error('priority')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Deadline --}}
    <div class="col-md-4 mb-3">
        <label for="deadline" class="form-label fw-semibold">Deadline</label>
        <input type="date" id="deadline" name="deadline"
               class="form-control @error('deadline') is-invalid @enderror"
               value="{{ old('deadline', isset($task->deadline) ? $task->deadline->format('Y-m-d') : '') }}">
        @error('deadline')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
