<?php

namespace Enl\Swiftmailer\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Pretty straightforward implementation of PSR-3 logger adapter
 * @package Enl\Swiftmailer\Logger
 */
class PsrAdapter implements \Swift_Plugins_Logger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var
     */
    private $logLevel;

    /**
     * PsrAdapter constructor.
     *
     * @param LoggerInterface $logger
     * @param string $logLevel All messages will be added with this level
     */
    public function __construct(LoggerInterface $logger, $logLevel = LogLevel::DEBUG)
    {
        $this->logger = $logger;
        $this->logLevel = $logLevel;
    }

    /**
     * Add a log entry.
     *
     * @param string $entry
     */
    public function add($entry)
    {
        call_user_func([$this->logger, $this->logLevel], $entry);
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
