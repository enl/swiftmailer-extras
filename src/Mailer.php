<?php


namespace Enl\Swiftmailer;

use Swift_Mime_Message;
use Swift_Spool;
use Swift_SpoolTransport;
use Swift_Transport;

/**
 * Class Mailer replaces original `Swift_Mailer` class
 * Adds an opportunity to switch between Spool or realtime Transport
 *
 * @package Enl\Swiftmailer
 * @author Alex Panshin <deadyaga@gmail.com>
 */
class Mailer extends \Swift_Mailer
{
    /**
     * @var Swift_Transport
     */
    private $realtimeTransport;

    /**
     * @var bool
     */
    private $forceNext = false;

    /**
     * Mailer constructor.
     * @param Swift_Transport $transport
     * @param Swift_Spool $spool
     */
    public function __construct(Swift_Transport $transport, Swift_Spool $spool)
    {
        $this->realtimeTransport = $transport;
        parent::__construct(new Swift_SpoolTransport($spool));
    }

    /**
     * Plans to send next message immediately, ignoring Spool
     * @return Mailer $this
     */
    public function immediately()
    {
        $this->forceNext = true;

        return $this;
    }

    /**
     * Sends a message to queue or to realtime transport if `immediately()` was called
     * @param Swift_Mime_Message $message
     * @param array $failedRecipients
     * @return int
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        if ($this->forceNext) {
            $this->forceNext = false;

            if (!$this->realtimeTransport->isStarted()) {
                $this->realtimeTransport->start();
            }

            return $this->realtimeTransport->send($message, $failedRecipients);
        }

        return parent::send($message, $failedRecipients);
    }
}
