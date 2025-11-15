<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use App\Models\Complaint;

class ComplaintSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Complaint $complaint;
    public ?string $buktiUrl = null;

    public function __construct(Complaint $complaint)
    {
        $this->complaint = $complaint;
        if ($complaint->bukti) {
            $this->buktiUrl = URL::temporarySignedRoute(
                'complaints.bukti',
                now()->addDays(7),
                ['complaint' => $complaint->id]
            );
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengaduan Baru: ' . $this->complaint->kategori_pengaduan,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.complaints.submitted',
            with: [
                'complaint' => $this->complaint,
                'buktiUrl' => $this->buktiUrl,
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
