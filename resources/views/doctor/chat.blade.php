@extends('doctor.app')

@section('title', 'الإستفسارات')

@section('content')
<div class="container" style="max-width: 700px; margin-top: 2rem;">
    @php
        use App\Models\Patient;

        $patient = Patient::find($patientId);
    @endphp

    <h2 class="text-center mb-4" style="color: #16a5b9;">محادثة مع {{ $patient ? $patient->full_name : 'المريض' }}</h2>

    <div id="chat-box"
        style="border: 1px solid #ccc; height: 400px; overflow-y: scroll; padding: 1rem; background: #f9f9f9;">
        @foreach ($messages as $message)
            <div style="margin-bottom: 10px; text-align: {{ $message->sender_type == 'doctor' ? 'right' : 'left' }};">
                <div
                    style="display: inline-block; background-color: {{ $message->sender_type == 'doctor' ? '#73a22a' : '#16a5b9' }}; color: white; padding: 8px 12px; border-radius: 15px; max-width: 70%;">
                    @if($message->message)
                        <div>{{ $message->message }}</div>
                    @endif
                    @if($message->image)
                        <div>
                            <img src="{{ $message->image }}" alt="صورة" style="max-width: 100%; margin-top: 5px; border-radius: 10px;">
                        </div>
                    @endif
                    <div style="font-size: 0.7em; margin-top: 2px; opacity: 0.7;">
                        {{ $message->created_at->format('H:i d/m/Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form id="chat-form" style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center;">
        @csrf
        <input type="hidden" id="patient_id" value="{{ $patientId }}">

        <input type="text" id="message-input" class="form-control" placeholder="اكتب رسالتك هنا..."
            autocomplete="off" style="flex: 1; min-width: 200px;">

        <input type="file" id="image-input" accept="image/*" style="max-width: 150px;">

        <button type="submit" class="btn btn-primary"
            style="background-color: #16a5b9; border-color: #16a5b9;">إرسال</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const imageInput = document.getElementById('image-input');
    const patientId = document.getElementById('patient_id').value;

    function scrollChatToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    scrollChatToBottom();

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const message = messageInput.value.trim();
        const imageFile = imageInput.files[0];

        if (!message && !imageFile) return;

        const formData = new FormData();
        formData.append('patient_id', patientId);
        formData.append('_token', '{{ csrf_token() }}');
        if (message) formData.append('message', message);
        if (imageFile) formData.append('image', imageFile);

        fetch("{{ route('doctor.chat.sendMessage') }}", {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const msg = data.message;
                const msgDiv = document.createElement('div');
                msgDiv.style.textAlign = 'right';
                msgDiv.style.marginBottom = '10px';

                const bubble = document.createElement('div');
                bubble.style.display = 'inline-block';
                bubble.style.backgroundColor = '#73a22a';
                bubble.style.color = 'white';
                bubble.style.padding = '8px 12px';
                bubble.style.borderRadius = '15px';
                bubble.style.maxWidth = '70%';

                if (msg.message) {
                    const textNode = document.createElement('div');
                    textNode.textContent = msg.message;
                    bubble.appendChild(textNode);
                }

                if (msg.image) {
                    const imgNode = document.createElement('img');
                    imgNode.src = msg.image;
                    imgNode.style.maxWidth = '100%';
                    imgNode.style.marginTop = '5px';
                    imgNode.style.borderRadius = '10px';
                    bubble.appendChild(imgNode);
                }

                const timeDiv = document.createElement('div');
                timeDiv.style.fontSize = '0.7em';
                timeDiv.style.marginTop = '2px';
                timeDiv.style.opacity = '0.7';
                timeDiv.textContent = new Date(msg.created_at).toLocaleTimeString();

                bubble.appendChild(timeDiv);
                msgDiv.appendChild(bubble);
                chatBox.appendChild(msgDiv);

                scrollChatToBottom();
                messageInput.value = '';
                imageInput.value = '';
            } else if(data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    });

    // Poll for new messages every 5 seconds
    let lastMessageId = {{ $messages->last() ? $messages->last()->id : 0 }};
    setInterval(() => {
        fetch("{{ route('doctor.chat.fetchMessages') }}?patient_id=" + patientId + "&last_message_id=" + lastMessageId)
            .then(response => response.json())
            .then(data => {
                data.messages.forEach(msg => {
                    if (msg.id > lastMessageId) {
                        lastMessageId = msg.id;
                        const msgDiv = document.createElement('div');
                        msgDiv.style.textAlign = msg.sender_type === 'doctor' ? 'right' : 'left';
                        msgDiv.style.marginBottom = '10px';

                        const bubble = document.createElement('div');
                        bubble.style.display = 'inline-block';
                        bubble.style.backgroundColor = msg.sender_type === 'doctor' ? '#73a22a' : '#16a5b9';
                        bubble.style.color = 'white';
                        bubble.style.padding = '8px 12px';
                        bubble.style.borderRadius = '15px';
                        bubble.style.maxWidth = '70%';

                        if (msg.message) {
                            const textNode = document.createElement('div');
                            textNode.textContent = msg.message;
                            bubble.appendChild(textNode);
                        }

                        if (msg.image) {
                            const imgNode = document.createElement('img');
                            imgNode.src = msg.image;
                            imgNode.style.maxWidth = '100%';
                            imgNode.style.marginTop = '5px';
                            imgNode.style.borderRadius = '10px';
                            bubble.appendChild(imgNode);
                        }

                        const timeDiv = document.createElement('div');
                        timeDiv.style.fontSize = '0.7em';
                        timeDiv.style.marginTop = '2px';
                        timeDiv.style.opacity = '0.7';
                        timeDiv.textContent = new Date(msg.created_at).toLocaleTimeString();

                        bubble.appendChild(timeDiv);
                        msgDiv.appendChild(bubble);
                        chatBox.appendChild(msgDiv);

                        scrollChatToBottom();
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching messages:', error);
            });
    }, 5000);
});
</script>
@endsection
