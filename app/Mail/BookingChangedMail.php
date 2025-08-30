<?php

// namespace App\Mail;

// use App\Models\Booking;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;

// class BookingChangedMail extends Mailable
// {
//     public function __construct(public Booking $booking) {}

//     public function envelope(): Envelope
//     {
//         return new Envelope(subject: 'Изменение бронирования №'.$this->booking->id);
//     }

//     public function content(): Content
//     {
//         return new Content(
//             markdown: 'emails.bookings.changed',
//             with: ['booking' => $this->booking],
//         );
//     }

//     public function attachments(): array { return []; }
// }
