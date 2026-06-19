@extends('layouts.user')

@section('content')
<style>
    .inbox-root {
        display: flex;
        height: calc(100vh - 90px);
        border: 0.5px solid #e0e0dc;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        position: relative;
    }

    /* ── Sidebar ── */
    .inbox-sidebar {
        width: 260px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        border-right: 0.5px solid #e0e0dc;
        background: #f7f7f6;
        z-index: 2;
        transition: transform 0.25s ease;
    }

    .sidebar-header {
        padding: 14px 16px 10px;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #888;
        border-bottom: 0.5px solid #e0e0dc;
        flex-shrink: 0;
    }

    .sidebar-list { overflow-y: auto; flex: 1; }

    .inquiry-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        cursor: pointer;
        border-left: 2px solid transparent;
        border-bottom: 0.5px solid #eeeeeb;
        transition: background 0.12s, border-color 0.12s;
    }

    .inquiry-item:hover { background: #fff; }

    .inquiry-item.active {
        background: #fff;
        border-left-color: #1a1a1a;
    }

    .inq-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 0.5px solid #e0e0dc;
    }

    .item-meta { overflow: hidden; flex: 1; min-width: 0; }

    .item-meta strong {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1a1a1a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-meta span {
        display: block;
        font-size: 12px;
        color: #888;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 1px;
    }

    /* ── Main panel ── */
    .inbox-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #fff;
    }

    .chat-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-bottom: 0.5px solid #e0e0dc;
        flex-shrink: 0;
    }

    .back-btn {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        color: #888;
    }

    .chat-info strong {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .chat-info span { font-size: 12px; color: #888; }

    .chat-body {
        flex: 1;
        overflow-y: auto;
        padding: 28px 22px;
    }

    .empty-state {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #bbb;
        gap: 8px;
        text-align: center;
    }

    .empty-state p { font-size: 13px; margin: 0; }

    .message-bubble { display: none; }
    .message-bubble.visible { display: block; }

    .bubble-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #aaa;
        margin-bottom: 8px;
    }

    .bubble-text {
        background: #f7f7f6;
        border: 0.5px solid #e0e0dc;
        border-radius: 2px 10px 10px 10px;
        padding: 14px 18px;
        font-size: 14px;
        line-height: 1.65;
        color: #1a1a1a;
        max-width: 600px;
    }

    .menu-btn {
        display: none;
        align-items: center;
        gap: 6px;
        background: none;
        border: 0.5px solid #e0e0dc;
        border-radius: 8px;
        cursor: pointer;
        padding: 6px 10px;
        font-size: 12px;
        color: #888;
        margin-left: auto;
    }

    .mobile-overlay {
        display: none;
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.3);
        z-index: 1;
    }

    /* ── Mobile breakpoint ── */
    @media (max-width: 640px) {
        .inbox-sidebar {
            position: absolute;
            top: 0; left: 0; bottom: 0;
            transform: translateX(-100%);
            box-shadow: none;
        }

        .inbox-sidebar.open {
            transform: translateX(0);
            box-shadow: 4px 0 16px rgba(0,0,0,.08);
        }

        .back-btn { display: flex; align-items: center; }
        .menu-btn { display: flex; }
        .mobile-overlay.visible { display: block; }
    }
</style>

<div class="container-fluid py-3">
    <div class="inbox-root" id="inboxRoot">
        <div class="mobile-overlay" id="overlay"></div>

        {{-- Sidebar --}}
        <aside class="inbox-sidebar" id="sidebar">
            <div class="sidebar-header">Inquiries</div>
            <div class="sidebar-list">
                @forelse($inquiries as $inquiry)
                    <div
                        class="inquiry-item"
                        data-name="{{ $inquiry->sender->name }}"
                        data-message="{{ $inquiry->message }}"
                        data-image="{{ asset('storage/' . $inquiry->sender->profile_image) }}"
                        data-property-title="{{ $inquiry->property->title }}"
                        data-property-image="{{ asset('storage/' . $inquiry->property->image) }}"
                        data-property-price="{{ $inquiry->property->price }}"
                    >
                        <img
                            src="{{ asset('storage/' . $inquiry->sender->profile_image) }}"
                            class="inq-avatar"
                            alt="{{ $inquiry->sender->name }}"
                        >
                        <div class="item-meta">
                            <strong>{{ $inquiry->sender->name }}</strong>
                            <span>{{ Str::limit($inquiry->message, 42) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted small py-4">No inquiries yet.</p>
                @endforelse
            </div>
        </aside>

        {{-- Main panel --}}
        <main class="inbox-main">
            <div class="chat-header">
                <button class="back-btn" id="backBtn" aria-label="Back to list">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 12H5M5 12l7-7M5 12l7 7"/>
                    </svg>
                </button>
                <img id="chatImage" src="" alt="" class="inq-avatar" style="display:none;">
                <div class="chat-info">
                    <strong id="chatName">Inbox</strong>
                    <span id="chatSub">Select a conversation</span>
                </div>
                <button class="menu-btn" id="menuBtn" aria-label="Open conversations">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12h18M3 6h18M3 18h18"/>
                    </svg>
                    Conversations
                </button>
            </div>

            <div class="chat-body">
                <div class="empty-state" id="emptyState">
                    <svg width="36" height="36" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <p>Choose a conversation to read the message</p>
                </div>
                <div class="message-bubble" id="bubble">
                    <div class="bubble-label">Message</div>
                    <div class="bubble-text" id="bubbleText">
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    const items    = document.querySelectorAll('.inquiry-item');
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('overlay');
    const menuBtn  = document.getElementById('menuBtn');
    const backBtn  = document.getElementById('backBtn');
    const chatImage = document.getElementById('chatImage');
    const chatName  = document.getElementById('chatName');
    const chatSub   = document.getElementById('chatSub');
    const emptyState = document.getElementById('emptyState');
    const bubble    = document.getElementById('bubble');
    const bubbleText = document.getElementById('bubbleText');
    const propCard = document.getElementById('prop-card');

    function openSidebar()  { sidebar.classList.add('open');    overlay.classList.add('visible'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('visible'); }

    menuBtn.addEventListener('click', openSidebar);
    backBtn.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);

    items.forEach(item => {
        item.addEventListener('click', function () {
            items.forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            chatImage.src = this.dataset.image;
            chatImage.style.display = 'block';
            chatName.textContent = this.dataset.name;
            chatSub.textContent  = 'Inquiry';
            bubbleText.innerHTML = '';

            const msg = document.createElement('p');
            msg.textContent = this.dataset.message;

            const img = document.createElement('img');
            img.src = this.dataset.propertyImage;
            img.className = 'img-fluid rounded mt-2';

            bubbleText.appendChild(msg);
            bubbleText.appendChild(img);

            emptyState.style.display = 'none';
            bubble.classList.add('visible');

            closeSidebar();
        });
    });
</script>
@endsection