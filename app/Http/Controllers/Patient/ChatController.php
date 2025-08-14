<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:patient');
    }

    public function chatWithDoctor($doctorId)
    {
        $patientId = Auth::id();

        $messages = ChatMessage::where(function ($query) use ($patientId, $doctorId) {
            $query->where('sender_id', $patientId)->where('sender_type', 'patient')
                  ->where('receiver_id', $doctorId)->where('receiver_type', 'doctor');
        })->orWhere(function ($query) use ($patientId, $doctorId) {
            $query->where('sender_id', $doctorId)->where('sender_type', 'doctor')
                  ->where('receiver_id', $patientId)->where('receiver_type', 'patient');
        })->orderBy('created_at', 'asc')->get();

        ChatMessage::where('receiver_id', $patientId)
            ->where('receiver_type', 'patient')
            ->where('sender_id', $doctorId)
            ->where('sender_type', 'doctor')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('patient.chat', compact('messages', 'doctorId'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|integer',
            'message' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $patientId = Auth::id();
        $messageContent = $request->message;
        $imageUrl = null;
        $type = 'text';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'chat_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('chat');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $imageUrl = asset('chat/' . $filename);

            if ($messageContent) {
                $type = 'text_image';
            } else {
                $type = 'image';
            }
        } elseif ($messageContent) {
            $type = 'text';
        } else {
            return response()->json(['success' => false, 'error' => 'رسالة فارغة']);
        }

        $chatMessage = ChatMessage::create([
            'sender_id' => $patientId,
            'sender_type' => 'patient',
            'receiver_id' => $request->doctor_id,
            'receiver_type' => 'doctor',
            'message' => $messageContent,
            'image' => $imageUrl,
            'type' => $type,
            'is_read' => false,
        ]);

        return response()->json(['success' => true, 'message' => $chatMessage]);
    }

    public function fetchMessages(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|integer',
            'last_message_id' => 'nullable|integer',
        ]);

        $patientId = Auth::id();
        $lastMessageId = $request->last_message_id ?? 0;

        $messages = ChatMessage::where(function ($query) use ($patientId, $request) {
            $query->where('sender_id', $patientId)->where('sender_type', 'patient')
                  ->where('receiver_id', $request->doctor_id)->where('receiver_type', 'doctor');
        })->orWhere(function ($query) use ($patientId, $request) {
            $query->where('sender_id', $request->doctor_id)->where('sender_type', 'doctor')
                  ->where('receiver_id', $patientId)->where('receiver_type', 'patient');
        })->where('id', '>', $lastMessageId)
          ->orderBy('created_at', 'asc')->get();

        ChatMessage::whereIn('id', $messages->where('receiver_id', $patientId)->pluck('id'))
            ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }
}
