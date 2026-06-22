<style>
.message-bubble{
    max-width: 75%;
    word-wrap: break-word;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
}

.sent-message{
    background: #0d6efd;
    color: #fff;
    border-bottom-right-radius: 6px !important;
}

.received-message{
    background: #f8f9fa;
    color: #212529;
    border: 1px solid #e9ecef;
    border-bottom-left-radius: 6px !important;
}
</style>
<div class="container-fluid p-3">
    @foreach($messages as $msg)
        <div class="d-flex mb-3 {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
            <div
                class="message-bubble px-3 py-2 rounded-4
                {{ $msg->sender_id == auth()->id() ? 'sent-message' : 'received-message' }}">
                
                <div>{{ $msg->message }}</div>

                <small class="d-block text-end mt-1 opacity-75">
                    {{ $msg->created_at->format('h:i A') }}
                </small>
            </div>
        </div>
    @endforeach
</div>