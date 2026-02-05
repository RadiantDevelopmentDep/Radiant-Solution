<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;

    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    public function build()
    {
        return $this->subject('New Service Inquiry: ' . $this->formData['name'])
                    ->view('emails.inquiry'); 
    }
}