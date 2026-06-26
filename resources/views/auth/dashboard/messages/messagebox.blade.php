@if(!$conversation)

<div class="h-100 d-flex justify-content-center align-items-center">
    <h4 class="text-muted">Select a conversation</h4>
</div>

@else

<div class="d-flex flex-column h-100">

    {{-- Header --}}
    <div class="border-bottom p-3">

        <div class="d-flex align-items-center">

            <img
                src="{{ asset('storage/'.$conversation->buyer->profile_image) }}"
                class="rounded-circle me-3"
                width="45"
                height="45"
                style="object-fit:cover"
            >

            <h5 class="mb-0">
                {{ $conversation->buyer->name }}
            </h5>

        </div>

    </div>


    {{-- Messages --}}
    <div
        id="chat-messages"
        class="flex-grow-1 overflow-auto p-3 bg-light"
    >

        @forelse($messages as $message)

            @if($message->sender_id == auth()->id())

                <div class="d-flex justify-content-end mb-3">

                    <div class="bg-primary text-white rounded px-3 py-2">

                        {{ $message->message }}

                    </div>

                </div>

            @else

                <div class="d-flex justify-content-start mb-3">

                    <div class="bg-white border rounded px-3 py-2">

                        {{ $message->message }}

                    </div>

                </div>

            @endif

        @empty

            <div class="text-center text-muted mt-5">

                No messages yet.

            </div>

        @endforelse

    </div>


    {{-- Input --}}
    <div class="border-top p-3">

        <form id="send-message-form">

            <div class="input-group">

                <input
                    id="message-input"
                    type="text"
                    class="form-control"
                    placeholder="Type your message..."
                    autocomplete="off"
                >

                <button
                    class="btn btn-primary"
                    type="submit"
                >
                    Send
                </button>

            </div>

        </form>

    </div>

</div>

@endif