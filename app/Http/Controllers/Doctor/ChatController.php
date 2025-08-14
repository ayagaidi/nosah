<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    // Show chat interface with a specific patient
    public function chatWithPatient($patientId)
    {
        $doctorId = Auth::id();

        // Get chat messages between this doctor and patient
        $messages = ChatMessage::where(function ($query) use ($doctorId, $patientId) {
            $query->where('sender_id', $doctorId)
                ->where('sender_type', 'doctor')
                ->where('receiver_id', $patientId)
                ->where('receiver_type', 'patient');
        })->orWhere(function ($query) use ($doctorId, $patientId) {
            $query->where('sender_id', $patientId)
                ->where('sender_type', 'patient')
                ->where('receiver_id', $doctorId)
                ->where('receiver_type', 'doctor');
        })->orderBy('created_at', 'asc')->get();

        return view('doctor.chat', compact('messages', 'patientId'));
    }

    // Send a new message to patient via AJAX
  public function sendMessage(Request $request)
{
    $request->validate([
        'patient_id' => 'required|integer',
        'message' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $doctorId = Auth::id();
    $messageContent = $request->message;
    $imagePath = null;
    $type = null;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = 'chat_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('chat');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);
        $imagePath = asset('chat/' . $filename);

        $type = $messageContent ? 'text_image' : 'image';
    } elseif ($messageContent) {
        $type = 'text';
    } else {
        return response()->json(['success' => false, 'error' => 'رسالة فارغة']);
    }

    $chatMessage = ChatMessage::create([
        'sender_id' => $doctorId,
        'sender_type' => 'doctor',
        'receiver_id' => $request->patient_id,
        'receiver_type' => 'patient',
        'message' => $messageContent,
        'image' => $imagePath,
        'type' => $type,
        'is_read' => false,
    ]);

    return response()->json(['success' => true, 'message' => $chatMessage]);
}

    // Upload image and return URL
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // max 2MB
        ]);

        $path = $request->file('image')->store('chat_images', 'public');

        $imageUrl = asset('storage/' . $path);

        return response()->json(['success' => true, 'imageUrl' => $imageUrl]);
    }

    // Fetch new messages via AJAX
    public function fetchMessages(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'last_message_id' => 'nullable|integer',
        ]);

        $doctorId = Auth::id();
        $lastMessageId = $request->last_message_id ?? 0;

        $messages = ChatMessage::where(function ($query) use ($doctorId, $request) {
            $query->where('sender_id', $doctorId)
                ->where('sender_type', 'doctor')
                ->where('receiver_id', $request->patient_id)
                ->where('receiver_type', 'patient');
        })->orWhere(function ($query) use ($doctorId, $request) {
            $query->where('sender_id', $request->patient_id)
                ->where('sender_type', 'patient')
                ->where('receiver_id', $doctorId)
                ->where('receiver_type', 'doctor');
        })->where('id', '>', $lastMessageId)
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json(['messages' => $messages]);
    }



      public function patients()
    {
        $patients = Patient::where('doctors_id',Auth::user()->id)->orderBy('created_at', 'DESC');
        return datatables()->of($patients)
          
            ->addColumn('show', function ($patient) {
                $patient_id = $patient->id;
                                return '<a href="' . route('doctor.chat.withPatient', $patient_id) . '"><i class="fa fa-comment-o"></i></a>';

            })
            ->rawColumns(['show'])
            ->make(true);
    }
    // List patients the doctor has chats with
    public function patientsList()
    {
        $doctorId = Auth::id();

        $patients = \App\Models\Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->distinct('patient_id')
            ->get()
            ->pluck('patient')
            ->filter();

        return view('doctor.patients_list', compact('patients'));
    }
}
