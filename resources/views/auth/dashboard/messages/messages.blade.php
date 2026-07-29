@extends('layouts.user')
@vite(['resources/js/app.js'])
@section('content')

<div class="container-fluid mt-4" style="height:75vh;">

    <div class="row h-100">

        {{-- Conversations --}}
        <div class="col-md-4 border-end h-100 overflow-auto" id="conversations-pane">

            @include('auth.dashboard.messages.conversations')

        </div>

        {{-- Chat --}}
        <div class="col-md-8 h-100 d-none d-md-block" id="chat-pane">

            {{-- Mobile back bar --}}
            <div class="d-md-none d-flex align-items-center border-bottom py-2 px-2">
                <button type="button" class="btn btn-sm btn-link text-decoration-none ps-0" id="back-to-conversations">
                    &larr; Back
                </button>
            </div>

            <div id="message-box" class="h-100">

                @include('auth.dashboard.messages.messagebox')

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')
<script>

let currentConversation = {{ $conversation ? $conversation->id : 'null' }};
let currentChannel = null;

const MOBILE_BREAKPOINT = 768;
function isMobile(){
    return window.innerWidth < MOBILE_BREAKPOINT;
}

/*
|--------------------------------------------------------------------------
| Mobile Pane Switching
|--------------------------------------------------------------------------
*/

function showChatPane(){

    if(!isMobile()) return;

    document.getElementById('conversations-pane').classList.add('d-none');

    const chatPane = document.getElementById('chat-pane');
    chatPane.classList.remove('d-none');
    chatPane.classList.add('d-block');

}

function showConversationsPane(){

    if(!isMobile()) return;

    document.getElementById('conversations-pane').classList.remove('d-none');

    const chatPane = document.getElementById('chat-pane');
    chatPane.classList.add('d-none');
    chatPane.classList.remove('d-block');

}

function resetPanesForViewport(){

    const conversationsPane = document.getElementById('conversations-pane');
    const chatPane = document.getElementById('chat-pane');

    if(isMobile()){

        // Mobile: show chat only if a conversation is already open
        if(currentConversation){
            conversationsPane.classList.add('d-none');
            chatPane.classList.remove('d-none');
            chatPane.classList.add('d-block');
        } else {
            conversationsPane.classList.remove('d-none');
            chatPane.classList.add('d-none');
            chatPane.classList.remove('d-block');
        }

    } else {

        // Desktop: always show both
        conversationsPane.classList.remove('d-none');
        chatPane.classList.remove('d-none');
        chatPane.classList.add('d-block');

    }

}

let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(resetPanesForViewport, 150);
});


function joinConversation(conversationId){
    // Leave previous channel
    if(currentChannel){
        window.Echo.leave(currentChannel);
    }

    currentChannel = `conversation.${conversationId}`;

    window.Echo.private(currentChannel)
        .listen('.message.sent', (e) => {

            console.log('New message:', e);

            // Reload current conversation
            loadConversation(conversationId);

        });

}
/*
|--------------------------------------------------------------------------
| Open Conversation
|--------------------------------------------------------------------------
*/

async function loadConversation(id){

    currentConversation = id;

    const url = "{{ route('dashboard.chat.conversation', ':id') }}"
        .replace(':id', id);

    const response = await fetch(url);

    const data = await response.json();

    document.getElementById('message-box').innerHTML = data.html;

    highlightConversation(id);

    attachSendEvent();

    attachBackEvent();

    scrollBottom();

    showChatPane();

}


/*
|--------------------------------------------------------------------------
| Highlight Selected Conversation
|--------------------------------------------------------------------------
*/

function highlightConversation(id){

    document.querySelectorAll('.conversation').forEach(item=>{

        item.classList.remove('active');

        if(item.dataset.id == id){

            item.classList.add('active', 'text-light');

        }

    });

}

function waitForEcho(callback) {
    if (window.Echo) {
        callback();
    } else {
        setTimeout(() => waitForEcho(callback), 100);
    }
}

/*
|--------------------------------------------------------------------------
| Back Button (mobile)
|--------------------------------------------------------------------------
*/

function attachBackEvent(){

    const backBtn = document.getElementById('back-to-conversations');

    if(!backBtn) return;

    backBtn.addEventListener('click', showConversationsPane);

}

document.addEventListener('DOMContentLoaded', () => {
    highlightConversation(currentConversation);
    attachSendEvent();
    attachBackEvent();
    scrollBottom();
    resetPanesForViewport();

    if (currentConversation) {
        waitForEcho(() => {
            joinConversation(currentConversation);
        });
    }
});


/*
|--------------------------------------------------------------------------
| Send Message
|--------------------------------------------------------------------------
*/

function attachSendEvent(){

    const form = document.getElementById('send-message-form');

    if(!form) return;

    form.addEventListener('submit', sendMessage);

}


async function sendMessage(e){

    e.preventDefault();

    const input = document.getElementById('message-input');

    const message = input.value.trim();

    if(message == '') return;

    const response = await fetch(
        "{{ route('dashboard.chat.send') }}",
    {

        method:'POST',

        headers:{
            'Content-Type':'application/json',
            'Accept':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },

        body:JSON.stringify({

            conversation_id: currentConversation,
            message: message

        })

    });

    const data = await response.json();

    if(data.success){

        input.value='';

        loadConversation(currentConversation);

    }

}


/*
|--------------------------------------------------------------------------
| Scroll
|--------------------------------------------------------------------------
*/

function scrollBottom(){

    const box = document.getElementById('chat-messages');

    if(box){

        box.scrollTop = box.scrollHeight;

    }

}

</script>

@endpush