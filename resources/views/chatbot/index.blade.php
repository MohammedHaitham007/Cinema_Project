@extends('layouts.app')
@section('title', 'Chatbot - Cinema Admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">

    <div class="pb-6 border-b border-slate-100 mb-6 flex items-center space-x-2">
        <span class="text-2xl">🎬</span>
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Cinema Assistant</h1>
            <p class="text-xs text-slate-500 mt-0.5">اسأل عن أي حاجة، وهرد عليك فورًا.</p>
        </div>
    </div>

    <!-- Messages Container -->
    <div id="messages" class="h-96 overflow-y-auto rounded-xl bg-slate-50 border border-slate-200 p-4 space-y-3 mb-4 flex flex-col"></div>

    <!-- Input Row -->
    <div class="flex items-center gap-2" dir="rtl">
        <input type="text"
               id="userInput"
               placeholder="اكتب رسالتك..."
               onkeydown="if(event.key==='Enter'){sendMessage()}"
               class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
        <button onclick="sendMessage()"
                id="sendBtn"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-lg shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            إرسال
        </button>
    </div>
</div>

<script>
function appendMessage(text, sender) {
    const messagesDiv = document.getElementById('messages');
    const wrapper = document.createElement('div');
    wrapper.setAttribute('dir', 'rtl');
    wrapper.className = sender === 'user' ? 'flex justify-start' : 'flex justify-end';

    const bubble = document.createElement('div');
    bubble.className = sender === 'user'
        ? 'max-w-[80%] bg-indigo-600 text-white text-sm rounded-2xl rounded-tl-sm px-4 py-2.5 shadow-sm'
        : 'max-w-[80%] bg-white border border-slate-200 text-slate-800 text-sm rounded-2xl rounded-tr-sm px-4 py-2.5 shadow-sm';
    bubble.innerText = text;

    wrapper.appendChild(bubble);
    messagesDiv.appendChild(wrapper);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

async function sendMessage() {
    const input = document.getElementById('userInput');
    const sendBtn = document.getElementById('sendBtn');
    const message = input.value.trim();
    if (!message) return;

    appendMessage(message, 'user');
    input.value = '';
    sendBtn.disabled = true;
    sendBtn.innerText = '...جاري الإرسال';

    try {
        const res = await fetch('/api/chatbot/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        });
        const data = await res.json();
        appendMessage(data.reply || 'حصل خطأ، حاول تاني', 'ai');
    } catch (err) {
        appendMessage('تعذر الاتصال بالسيرفر', 'ai');
    }

    sendBtn.disabled = false;
    sendBtn.innerText = 'إرسال';
}
</script>
@endsection
