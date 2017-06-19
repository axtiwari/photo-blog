<?php

namespace Core\Mail;

use Illuminate\Mail\Mailable;

/**
 * Class ContactMessage.
 *
 * @property array data
 * @package Core\Mail
 */
class ContactMessage extends Mailable
{
    /**
     * ContactMessage constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to(config('mail.address.administrator'))
            ->replyTo($this->data['email'])
            ->subject(sprintf('%s - %s - %s', config('app.name'), trans('mails.contact-message.subject'), $this->data['subject']))
            ->view('core.mails.contact-message', $this->data);
    }
}