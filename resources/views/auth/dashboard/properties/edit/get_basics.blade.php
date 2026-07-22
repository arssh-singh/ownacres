<div class="card border rounded-3 p-3">
    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">BASIC INFO</p>
    <div class="mb-3">
        <label class="form-label small">Title</label>
        <input type="text" name="title" class="form-control" value="{{ $property->display_title }}">
    </div>
    <div>
        <label class="form-label small">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ $property->display_description }}</textarea>
    </div>
    <input type="hidden" name="changed[basics]" value="0">
</div>
@push('scripts')
<script>
const titleInput = document.querySelector('input[name="title"]');
const descriptionInput = document.querySelector('textarea[name="description"]');
const basicfields = [titleInput, descriptionInput];
basicfields.forEach(field => {
    field.addEventListener('input', () => {
        document.querySelector('input[name="changed[basics]"]').value = '1';
    });
    field.addEventListener('change', () => {
        document.querySelector('input[name="changed[basics]"]').value = '1';
    });
});
</script>
@endpush