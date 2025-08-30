<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class BookingReminderMail extends Mailable
{
    public function __construct(public Booking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Напоминание о заезде (бронь №'.$this->booking->id.')');
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.reminder',
            with: ['booking' => $this->booking],
        );
    }

    public function attachments(): array { return []; }
}
