<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OrderCompletedToBuyer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Orders $order, public array $invoice)
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Completed To Buyer',
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
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     * @throws \Exception
     */
    public function attachments(): array
    {
        if (!Storage::exists($this->invoice['filepath'])) {
            throw new \RuntimeException('Attachment file does not exist: ' . $this->invoice['filepath']);
        }

        return [
            Attachment::fromStorage($this->invoice['filepath'])
                ->as('invoice.pdf')
                ->withMime('application/pdf')
        ];
    }
}
