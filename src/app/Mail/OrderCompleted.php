<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public array $orderData;

    public function __construct(array $orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): OrderCompleted
    {
        return $this->view('emails.completed', ['data' => $this->parseEmailArray()])->subject('Order Completed');
    }

    /**
     * @return array
     */
    private function parseEmailArray(): array
    {
        return [
            'currency' => $this->orderData['currency_value']['currency']['full_name'],
            'currency_price' => round((float)$this->orderData['currency_value']['value'], 2),
            'surcharge_percentage' => round((float)$this->orderData['surcharge_percentage'], 2),
            'surcharge_amount' => round((float)$this->orderData['surcharge_amount'], 2),
            'purchased_amount' => round((float)$this->orderData['purchased_amount'], 2),
            'paid_amount' => round((float)$this->orderData['paid_amount'], 2),
            'discount_percentage' => round((float)$this->orderData['discount_percentage'], 2),
            'discount_amount' => round((float)$this->orderData['discount_amount'], 2),
        ];
    }
}
