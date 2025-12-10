<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Request as RequestModel;

class ServiceRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * La solicitud de servicio rechazada.
     */
    public RequestModel $serviceRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(RequestModel $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actualización sobre tu solicitud de servicio - FrontJS Solutions',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.service_rejected',
            with: [
                'request' => $this->serviceRequest,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
