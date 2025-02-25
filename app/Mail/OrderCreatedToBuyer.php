<?php

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailables\Address;
use Symfony\Component\Mime\Email;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreatedToBuyer extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Orders $order,
        public string $totalPrice,
        public array $invoice,
    )
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@desinaumova.com', 'Деси Наумова'),
            replyTo: [new Address('info@desinaumova.com', 'No Reply')],
            subject: 'Поръчка #' . $this->order->order_id . ' - Деси Наумова'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.orders.new-to-buyer'
        );
    }

    public function withSymfonyMessage($callback)
    {
        $callback(function (Email $message) {
            $message->getHeaders()->addTextHeader('X-Mailer', 'PHP/' . phpversion());
            $message->getHeaders()->addTextHeader('X-Entity-Ref-ID', time());
        });
    }

    public function attachments(): array
    {
        if (!file_exists($this->invoice['filepath'])) {
            throw new \RuntimeException('Attachment file does not exist: ' . $this->invoice['filepath']);
        }

        return [
            Attachment::fromPath($this->invoice['filepath'])
                ->as($this->order->order_id . '.pdf')
                ->withMime('application/pdf')
        ];
    }
}
