<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    protected $header;
    protected $img;
    protected $messenger;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($header, $img, $messenger)
    {
        $this->header = $header;
        $this->img = $img;
        $this->messenger = $messenger;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('template.mail', ['messenger' => $this->messenger, 'header' => $this->header, 'img' => $this->img]);
    }
}
