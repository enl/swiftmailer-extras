<?php

namespace Enl\Swiftmailer\Logger;

use Psr\Log\LoggerInterface;

class PsrAdapter implements \Swift_Plugins_Logger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Add a log entry.
     *
     * @param string $entry
     */
    public function add($entry)
    {
        $this->logger->debug($entry);
    }

    /**
     * Clear the log contents.
     */
    public function clear()
    {
        // Not implemented
    }

    /**
     * Get this log as a string.
     */
    public function dump()
    {
        // Not implemented
    }
}
