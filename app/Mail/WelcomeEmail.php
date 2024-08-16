<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $current_employee;

    /**
     * Create a new message instance.
     */
    public function __construct($user,$current_employee)
    {
        $this->user = $user;
        $this->current_employee = $current_employee;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.welcome')
                    ->subject('Welcome to CloudArchive')
                    ->with([
                        'firstName' => $this->user->first_name,
                        'lastName' => $this->user->last_name,
                        'departmentName' => $this->user->department->department,
                        'employee_first_name' => $this->current_employee->first_name,
                        'employee_last_name' => $this->current_employee->last_name,
                        'employee_position' => $this->current_employee->department->department,
                        'employee_email' => $this->current_employee->email,
                    ]);
    }
}
