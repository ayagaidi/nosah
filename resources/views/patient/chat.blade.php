@extends('patient.app')

@section('title', 'محادثة مع الطبيب')

@section('content')
<div class="inner-welcome pt85 bg4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="title">
                    <h1>محادثة مع الطبيب</h1>
                </div>
                <div class="bread-crumb text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">محادثة مع الطبيب</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="max-width: 700px; margin-top: 2rem;">
    <div id="chat-box" style="border: 1px solid #ccc; height: 400px; overflow-y: auto; padding: 1rem; background: #f9f9f9; border-radius: 8px;">
        @foreach($messages as $message)
            <div style="margin-bottom: 10px; text-align: {{ $message->sender_type == 'patient' ? 'right' : 'left' }};">
                <div style="display: inline-block; background-color: {{ $message->sender_type == 'patient' ? '#73a22a' : '#16a5b9' }}; color: white; padding: 8px 12px; border-radius: 15px; max-width: 70%;">
                    @if($message->type === 'image' || $message->type === 'text_image')
                        <img src="{{ $message->image }}" alt="صورة" style="max-width: 100%; border-radius: 10px;"><br>
                    @endif

                    @if($message->type === 'text' || $message->type === 'text_image')
                        {{ $message->message }}
                    @endif

                    <div style="font-size: 0.7em; margin-top: 2px; opacity: 0.8;">
                        {{ $message->created_at->format('H:i d/m/Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form id="chat-form" style="margin-top: 1rem;" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="doctor_id" value="{{ $doctorId }}">
        <div class="input-group">
            <input type="text" id="message-input" class="form-control" placeholder="اكتب رسالتك هنا..." autocomplete="off">
            <input type="file" id="image-input" name="image" accept="image/*" style="margin-left: 10px;">
            <button type="submit" class="btn btn-primary" style="background-color: #16a5b9; border-color: #16a5b9;">إرسال</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const imageInput = document.getElementById('image-input');
    const doctorId = document.getElementById('doctor_id').value;

    function scrollChatToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    scrollChatToBottom();

    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const messageText = messageInput.value.trim();
        const imageFile = imageInput.files[0];

        if (!messageText && !imageFile) {
            alert("يرجى إدخال رسالة أو اختيار صورة");
            return;
        }

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('doctor_id', doctorId);
        if (messageText) formData.append('message', messageText);
        if (imageFile) formData.append('image', imageFile);

        fetch("{{ route('patient.chat.sendMessage') }}", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                appendMessage(data.message);
                messageInput.value = '';
                imageInput.value = '';
                scrollChatToBottom();
            } else {
                alert('فشل إرسال الرسالة');
            }
        });
    });

    function appendMessage(message) {
        const msgDiv = document.createElement('div');
        msgDiv.style.textAlign = message.sender_type === 'patient' ? 'right' : 'left';
        msgDiv.style.marginBottom = '10px';

        const bubble = document.createElement('div');
        bubble.style.display = 'inline-block';
        bubble.style.backgroundColor = message.sender_type === 'patient' ? '#73a22a' : '#16a5b9';
        bubble.style.color = 'white';
        bubble.style.padding = '8px 12px';
        bubble.style.borderRadius = '15px';
        bubble.style.maxWidth = '70%';

        if (message.type === 'image' || message.type === 'text_image') {
            const img = document.createElement('img');
            img.src = message.image;
            img.style.maxWidth = '100%';
            img.style.borderRadius = '10px';
            bubble.appendChild(img);
        }

        if (message.type === 'text' || message.type === 'text_image') {
            const text = document.createElement('div');
            text.textContent = message.message;
            bubble.appendChild(text);
        }

        const timeDiv = document.createElement('div');
        timeDiv.style.fontSize = '0.7em';
        timeDiv.style.marginTop = '2px';
        timeDiv.style.opacity = '0.7';
        timeDiv.textContent = new Date().toLocaleString();

        bubble.appendChild(timeDiv);
        msgDiv.appendChild(bubble);
        chatBox.appendChild(msgDiv);
    }

    let lastMessageId = {{ $messages->last() ? $messages->last()->id : 0 }};

    setInterval(() => {
        fetch(`{{ route('patient.chat.fetchMessages') }}?doctor_id=${doctorId}&last_message_id=${lastMessageId}`)
            .then(res => res.json())
            .then(data => {
                data.messages.forEach(msg => {
                    if (msg.id > lastMessageId) {
                        lastMessageId = msg.id;
                        appendMessage(msg);
                        scrollChatToBottom();
                    }
                });
            });
    }, 5000);
});
</script>
@endsection