<?php

namespace Xand\Component\Mailer;

/**
 * Class MailerManager
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
abstract class MailerManager
{
    /**
     * @var object
     */
    protected $mailer;

    /**
     * MailManager constructor.
     *
     * @param $mailer
     */
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param $mailer
     *
     * @return static
     */
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * @return object
     */
    public function getMailer()
    {
        return $this->mailer;
    }
}