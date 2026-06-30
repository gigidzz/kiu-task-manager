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

{{-- Tags (Many-to-Many) --}}
<div class="mb-3">
    <label class="form-label fw-semibold">Tags</label>
    <div class="d-flex flex-wrap gap-3">
        @php $selectedTags = old('tags', isset($task) ? $task->tags->pluck('id')->all() : []); @endphp
        @forelse($tags as $tag)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tags[]"
                       value="{{ $tag->id }}" id="tag-{{ $tag->id }}"
                       @checked(in_array($tag->id, $selectedTags))>
                <label class="form-check-label" for="tag-{{ $tag->id }}">
                    <span class="badge" style="background: {{ $tag->color }};">{{ $tag->name }}</span>
                </label>
            </div>
        @empty
            <span class="text-muted small">No tags available yet.</span>
        @endforelse
    </div>
    @error('tags')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

{{-- Attachment (File Upload) --}}
<div class="mb-3">
    <label for="attachment" class="form-label fw-semibold">Attachment</label>
    <input type="file" id="attachment" name="attachment"
           class="form-control @error('attachment') is-invalid @enderror"
           accept=".jpg,.jpeg,.png,.pdf">
    <div class="form-text">Optional. JPG, PNG, or PDF — max 2&nbsp;MB.</div>
    @error('attachment')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($task) && $task->attachment)
        <div class="mt-2 small">
            <i class="bi bi-paperclip me-1"></i>
            <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank">Current attachment</a>
            <span class="text-muted">— uploading a new file replaces it.</span>
        </div>
    @endif
</div>
