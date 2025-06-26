<?php

namespace App\Mail;

use App\Models\BloodDonation;
use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonorAssignmentNotification extends Mailable
{
    use SerializesModels;

    public $bloodDonation;
    public $bloodRequest;
    public $donor;
    public $requester;
    public $isDonor;

    /**
     * Create a new message instance.
     */
    public function __construct(BloodDonation $bloodDonation, bool $isDonor = true)
    {
        $this->bloodDonation = $bloodDonation;
        $this->bloodRequest = $bloodDonation->bloodRequest;
        $this->donor = $bloodDonation->donor;
        $this->requester = $bloodDonation->bloodRequest->user;
        $this->isDonor = $isDonor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isDonor 
            ? "You've Been Assigned as a Blood Donor - One2One4 Blood Donation" 
            : "A Donor Has Been Assigned to Your Blood Request - One2One4 Blood Donation";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->isDonor 
            ? 'emails.donor-assignment-notification' 
            : 'emails.requester-assignment-notification';

        return new Content(
            view: $view,
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
