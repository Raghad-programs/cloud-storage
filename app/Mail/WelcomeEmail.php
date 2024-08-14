<?php

namespace App\Mail;

use Faker\Provider\Address;
use Flasher\Prime\Notification\Envelope;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    // public function envelope():Envelope
    // {
    //     return new Envelope(
    //         subject:'Weolcome Email',
    //         from: new Address('mailtrap@gmail.com','Admin')
    //         //may add the admain name 
    //     );
    // }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to our application!')
                    ->view('emails.welcome')
                    ->with([
                        'name' => $this->name,
                    ]);

    }
}