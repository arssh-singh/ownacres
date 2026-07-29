<div class="list-group rounded-0">

    @forelse($conversations as $conversation)

        <button
            type="button"
            class="list-group-item list-group-item-action conversation"
            data-id="{{ $conversation->id }}"
            onclick="loadConversation({{ $conversation->id }})"
        >

            <div class="d-flex align-items-center">

                <img
                    src="{{ $conversation->buyer->profile_image_url }}"
                    class="rounded-circle me-3"
                    width="55"
                    height="55"
                    style="object-fit:cover"
                >

                <div>

                    <h6 class="mb-0">
                        {{ $conversation->buyer->name }}
                    </h6>

                    <small>
                        Conversation #{{ $conversation->id }}
                    </small>

                </div>

            </div>

        </button>

    @empty

        <div class="text-center p-4">

            <h5>No conversations found.</h5>

        </div>

    @endforelse

</div>