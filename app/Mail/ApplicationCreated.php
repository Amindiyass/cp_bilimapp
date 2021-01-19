<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Application
     */
    protected $application;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->subject = 'Новая заявка #'.$application->id;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.application_created')->with([
            'id' => $this->application->id,
            'phone' => $this->application->phone,
            'name'  => $this->application->name
        ]);
    }
}
