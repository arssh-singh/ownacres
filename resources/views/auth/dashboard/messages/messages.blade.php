@extends('layouts.user')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1>Messages</h1>
            <p>This is the messages page.</p>
        </div>
        <div class="col-lg-4 d-lg-block d-none">
            @include('auth.dashboard.messages.people', compact('conversations'))
        </div>
        <div class="col-8" id="msg-box">
            <div class="conversationg-list" id="msg-box">
                @include('auth.dashboard.messages.messagebox')
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const conversationElements = document.querySelectorAll('.conversation-item');
        const msgBox = document.getElementById('msg-box');
        let isLoading = false;

        conversationElements.forEach(element => {
            element.addEventListener('click', async function () {
                const senderId = this.dataset.conversationId;

                // Ignore clicks while a request is in flight, or on the already-active conversation
                if (isLoading || this.classList.contains('active')) {
                    return;
                }

                isLoading = true;

                // Update active state
                conversationElements.forEach(item => item.classList.remove('active'));
                this.classList.add('active');

                // Light loading indicator in the message pane
                msgBox.innerHTML = '<div class="text-center text-muted p-4">Loading…</div>';

                try {
                    const response = await fetch('{{ route('dashboard.messages') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ sender_id: senderId })
                    });

                    if (!response.ok) {
                        throw new Error(`Request failed with status ${response.status}`);
                    }

                    const messages = await response.json();
                    msgBox.innerHTML = messages.html;
                } catch (error) {
                    console.error('Failed to load conversation:', error);
                    msgBox.innerHTML = '<div class="text-center text-danger p-4">Couldn\'t load this conversation. Please try again.</div>';
                } finally {
                    isLoading = false;
                }
            });
        });
    });
</script>
@endpush