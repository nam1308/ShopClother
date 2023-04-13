<?php

namespace App\Jobs;

use App\Mail\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messenger;
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messenger, $data)
    {
        $this->messenger = $messenger;
        $this->data = $data;
        $this->queue = 'notification';
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->data as $user) {
            // dd($user->email);
            Mail::to($user->email)->send(new Notification($this->messenger[0], $this->messenger[1], $this->messenger[2]));
        }
    }
}
