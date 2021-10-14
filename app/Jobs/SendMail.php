<?php

namespace App\Jobs;

use App\Mail\SendMail as MailSendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data ;
    public $post;
   

    public function __construct($data,$post)
    {
        $this->data = $data;
        $this->post = $post;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->data as $dataemail){
         
            Mail::to($dataemail->email)->send(new MailSendMail($this->post));
        }
    }
}
