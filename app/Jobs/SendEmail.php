<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\MailNotify;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $messenger;
    protected $users;
    protected $type;
    protected $email;
    protected $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messenger, $data = null, $type = 1, $email = '', $token = '')
    {
        $this->messenger = $messenger;
        $this->data = $data;
        $this->type = $type;
        $this->email = $email;
        $this->token = $token;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 1) {
            foreach ($this->data as $user) {
                Mail::to($user->email)->send(new MailNotify($this->messenger, $this->type, $this->data, $this->token));
            }
        } else {
            Mail::to($this->email)->send(new MailNotify($this->messenger, $this->type, $this->email, $this->token));
        }
    }
}
