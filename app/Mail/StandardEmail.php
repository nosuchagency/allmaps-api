<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StandardEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;
    public $emailCC;
    public $emailContent;

    /**
     * Create a new message instance.
     *
     * @param string $emailSubject
     * @param array $emailCC
     * @param string $emailContent
     *
     * @return void
     */
    public function __construct(string $emailSubject, array $emailCC, string $emailContent)
    {
        $this->emailSubject = $emailSubject;
        $this->emailCC = $emailCC;
        $this->emailContent = $emailContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->emailSubject)
            ->cc($this->emailCC)
            ->html($this->emailContent);
    }
}
