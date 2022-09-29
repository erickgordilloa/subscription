<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->subject('Donaciones | Alianza Samborondón')->markdown('emails.notification');

        //$message = $this->subject('Resultados de Rayos X')->view('emails.rayosx',compact('user','pdf'));
        
        $count  = 0;
        foreach ($this->transaction->tipo->adjunto as $key => $file) { 
            $count = $key+1;
            //$location = storage_path("app/public/4/LofqmFXsxxeAvJEZQpRluDzCJD6GzmPf5I747gpi.pdf");
             $message->attach(storage_path("app/public/adjuntos/".$this->transaction->tipo->id.'/'.Str::replaceArray('/storage',[''],$file->archivo)));
        }

        return $message;
    }
}
