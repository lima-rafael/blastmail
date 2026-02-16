<?php

namespace App\Mail;

use App\Models\Campaigns;
use App\Models\CampaignMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailCampaign extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Campaigns $campaigns,
        public CampaignMail $mail
    ){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->campaigns->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.email-campaign',
            with:[
                'body' => $this->getBody()
            ]
        );
    }

    public function getBody()
    {
        $body = $this->campaigns->body;
        $pattern = '/href="([^"]*)"/';
        preg_match_all($pattern, $body, $matches);
        foreach ($matches[1] as $index => $oldValue) {
            $newValue = 'href="' . route('tracking.clicks', ['mail' => $this->mail, 'f' => $oldValue]) . '"';
            $body = str_replace($matches[0][$index], $newValue, $body);
        }
        return $body;
    }

}
