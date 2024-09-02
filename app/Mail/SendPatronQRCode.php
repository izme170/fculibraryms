<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendPatronQRCode extends Mailable
{
    use Queueable, SerializesModels;

    public $qrcodeImagePath;

    /**
     * Create a new message instance.
     */
    public function __construct($qrcode)
    {
        $this->qrcodeImagePath = 'qrcodes/' . uniqid() . '.png';
        Storage::disk('local')->put($this->qrcodeImagePath, QrCode::margin(20)->format('png')->size(300)->generate($qrcode));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your FCU Library QR Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.patron_qrcode',
            with: [
                'qrcodeImagePath' => storage_path('app/' . $this->qrcodeImagePath),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path('app/' . $this->qrcodeImagePath))
                ->as('QRCode.png')
                ->withMime('image/png'),
        ];
    }

    public function __destruct()
    {
        Storage::disk('local')->delete($this->qrcodeImagePath);
    }
}
