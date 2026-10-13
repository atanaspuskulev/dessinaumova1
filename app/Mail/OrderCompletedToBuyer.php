<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCompletedToBuyer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Orders $order,
        public string $totalPrice,
        public array $invoice,
    )
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order #' . $this->order->order_id . ' has been completed.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.orders.buyer-completed-order',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     * @throws \Exception
     */
    public function attachments(): array
    {
        if (!file_exists($this->invoice['filepath'])) {
            throw new \RuntimeException('Attachment file does not exist: ' . $this->invoice['filepath']);
        }

        return [
            Attachment::fromPath($this->invoice['filepath'])
                ->as('invoice_' . $this->order->order_id . '.pdf')
                ->withMime('application/pdf')
        ];
    }
}
