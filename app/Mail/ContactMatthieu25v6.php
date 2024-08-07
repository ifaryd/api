<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Log;

class ContactMatthieu25v6 extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $message;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $message, $email)
    {
        $this->name = $name;
        $this->message = $message;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info([
            'name' => $this->name,
            'message' => $this->message,
            'email' => $this->email,
        ]);

        return $this->view('mail.contact')
        ->with('data', [
            'name' => $this->name,
            'message' => $this->message,
            'email' => $this->email,
        ]);
    }
}
