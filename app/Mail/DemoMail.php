<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        //
        return $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {    return $this->view('mails.send')
        ->from('minhnghia101022@gmail.com','UNIMART')
        ->subject('[UNIMART STORE] Xác Nhận Đơn Hàng Tại Cửa Hàng UNIMART')
        ->with($this->data);
        
    }
}

