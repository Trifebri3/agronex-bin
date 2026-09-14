@extends('layouts.mobile')

@section('title', 'Tanya AI - denrawit x agronex')

@section('content')
<div class="flex flex-col h-[calc(100vh-140px)]">
    
    <!-- Chat Header -->
    <div class="px-4 py-4 border-b border-slate-100 bg-white/50 backdrop-blur-sm sticky top-[60px] z-40">
        <div class="flex items-center gap-3">
            <div class="relative">
                <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 leading-none">Agronex AI</h2>
                <span class="text-xs text-slate-500">Online • Siap membantu</span>
            </div>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
        <!-- AI Message -->
        <div class="flex gap-3 max-w-[85%]">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-400 to-blue-500 flex-shrink-0 flex items-center justify-center text-white mt-1">
                <span class="text-xs font-bold">AI</span>
            </div>
            <div class="bg-white border border-slate-100 p-3 rounded-2xl rounded-tl-sm shadow-sm text-sm text-slate-700 leading-relaxed">
                Halo! Saya asisten AI Anda. Ada yang bisa saya bantu terkait lahan atau tanaman Anda hari ini?
            </div>
        </div>

        <!-- System Notice -->
        <div class="flex justify-center my-4">
            <span class="bg-slate-100 text-slate-500 text-xs px-3 py-1 rounded-full">Percakapan dimulai</span>
        </div>
    </div>

    <!-- Chat Input Area -->
    <div class="p-4 bg-white border-t border-slate-100 pb-safe">
        <form id="chat-form" class="flex gap-2 relative">
            <input type="text" id="chat-input" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-full pl-4 pr-12 py-3 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all" placeholder="Tanya tentang pupuk, cuaca...">
            
            <button type="submit" class="absolute right-1.5 top-1.5 w-9 h-9 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full flex items-center justify-center transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform rotate-90" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
            </button>
        </form>
    </div>

</div>

@push('scripts')
<script>
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    function appendUserMessage(text) {
        const msgHtml = `
        <div class="flex gap-3 max-w-[85%] ml-auto justify-end">
            <div class="bg-emerald-500 p-3 rounded-2xl rounded-tr-sm shadow-sm text-sm text-white leading-relaxed">
                ${text}
            </div>
        </div>`;
        chatMessages.insertAdjacentHTML('beforeend', msgHtml);
        scrollToBottom();
    }

    function appendAIMessage(text) {
        const msgHtml = `
        <div class="flex gap-3 max-w-[85%]">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-400 to-blue-500 flex-shrink-0 flex items-center justify-center text-white mt-1">
                <span class="text-xs font-bold">AI</span>
            </div>
            <div class="bg-white border border-slate-100 p-3 rounded-2xl rounded-tl-sm shadow-sm text-sm text-slate-700 leading-relaxed">
                ${text}
            </div>
        </div>`;
        chatMessages.insertAdjacentHTML('beforeend', msgHtml);
        scrollToBottom();
    }

    function appendTypingIndicator() {
        const id = 'typing-' + Date.now();
        const msgHtml = `
        <div class="flex gap-3 max-w-[85%]" id="${id}">
            <div class="w-8 h-8 rounded-full bg-emerald-500 flex-shrink-0 flex items-center justify-center text-white mt-1">
                <span class="text-xs font-bold">AI</span>
            </div>
            <div class="bg-white border border-slate-100 p-3 rounded-2xl rounded-tl-sm shadow-sm flex items-center gap-1">
                <div class="w-2 h-2 bg-slate-300 rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-slate-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 bg-slate-300 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
            </div>
        </div>`;
        chatMessages.insertAdjacentHTML('beforeend', msgHtml);
        scrollToBottom();
        return id;
    }

    function removeElement(id) {
        const el = document.getElementById(id);
        if(el) el.remove();
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if(!text) return;

        appendUserMessage(text);
        chatInput.value = '';
        
        const typingId = appendTypingIndicator();

        // Simulate API request
        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: text })
        })
        .then(res => res.json())
        .then(data => {
            removeElement(typingId);
            appendAIMessage(data.reply);
        })
        .catch(err => {
            removeElement(typingId);
            appendAIMessage("Maaf, terjadi kesalahan jaringan.");
        });
    });
</script>
@endpush
@endsection
