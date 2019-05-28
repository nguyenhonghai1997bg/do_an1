<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;

class OrderSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $paymented;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $paymented = 0)
    {
        $this->order = $order;
        $this->paymented = $paymented;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orderSuccess')
            ->subject("Đặt hàng thành công")
            ->with([
                'order' => $this->order,
                'paymented' => $this->paymented,
            ]);
    }
}
