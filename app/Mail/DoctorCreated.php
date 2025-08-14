<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Doctor;

class DoctorCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $doctor;
    public $plainPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(Doctor $doctor, string $plainPassword)
    {
        $this->doctor        = $doctor;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Your Doctor Portal Credentials')
            ->view('emails.doctor_created')
            ->with([
                'name'     => $this->doctor->fullname,
                'username' => $this->doctor->username,
                'password' => $this->plainPassword,
                'loginUrl' => route('login'),
            ]);
    }
}
