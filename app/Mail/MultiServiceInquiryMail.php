<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MultiServiceInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;

    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    public function build()
    {
        return $this->subject('New Multi-Service Brief: ' . $this->formData['name'])
                    ->view('emails.multi_inquiry'); 
}
}