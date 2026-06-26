@extends('layouts.user')

@section('content')

<div class="container-fluid mt-4" style="height:75vh;">

    <div class="row h-100">

        {{-- Conversations --}}
        <div class="col-md-4 border-end h-100 overflow-auto">

            @include('auth.dashboard.messages.conversations')

        </div>

        {{-- Chat --}}
        <div class="col-md-8 h-100">

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

    scrollBottom();

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

            item.classList.add('active');

        }

    });

}


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


document.addEventListener('DOMContentLoaded', ()=>{

    highlightConversation(currentConversation);

    attachSendEvent();

    scrollBottom();

});

</script>

@endpush