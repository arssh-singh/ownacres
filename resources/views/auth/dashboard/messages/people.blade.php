<style>
.conversation-item {
    cursor: pointer;
    transition: background-color .15s ease;
}

.conversation-item:hover {
    background-color: #f5f5f5;
}

.conversation-item.active {
    background-color: #000;
    color: #fff;
}

.conversation-item.active .conversation-time,
.conversation-item.active .conversation-preview {
    color: rgba(255, 255, 255, .65);
}

.avatar-fallback {
    width: 48px;
    height: 48px;
    background-color: #e9ecef;
    color: #495057;
    font-weight: 600;
    font-size: 1rem;
}

.conversation-item.active .avatar-fallback {
    background-color: #fff;
    color: #000;
}

.conversation-preview {
    font-size: .875rem;
    color: #6c757d;
}

.conversation-time {
    font-size: .75rem;
    color: #adb5bd;
}

.min-w-0 {
    min-width: 0; /* needed for text-truncate inside flex children */
}
</style>
@foreach ($conversations as $inq)
    <div class="conversation-item d-flex align-items-center gap-3 p-3 border-bottom {{ $selectedConversation && $inq->sender_id == $selectedConversation->sender_id ? 'active' : '' }}"
         data-conversation-id="{{ $inq->sender_id }}">

        @if ($inq->sender->profile_image)
            <img src="{{ asset('storage/' . $inq->sender->profile_image) }}"
                 class="rounded-circle flex-shrink-0"
                 style="width: 48px; height: 48px; object-fit: cover;"
                 alt="{{ $inq->sender->name }}">
        @else
            <div class="avatar-fallback rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center">
                {{ strtoupper(substr($inq->sender->name, 0, 1)) }}
            </div>
        @endif

        <div class="flex-grow-1 min-w-0">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-semibold text-truncate">{{ $inq->sender->name }}</span>
                @if ($inq->created_at)
                    <small class="conversation-time flex-shrink-0 ms-2">
                        {{ $inq->created_at->diffForHumans(null, true) }}
                    </small>
                @endif
            </div>
            <div class="conversation-preview text-truncate">{{ $inq->message }}</div>
        </div>
    </div>
@endforeach