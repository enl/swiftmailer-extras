<?php


namespace Enl\Swiftmailer\Test\Logger;

use Mockery as m;
use Enl\Swiftmailer\Logger\PsrAdapter;
use Psr\Log\LoggerInterface;

class PsrAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var LoggerInterface|m\Mock
     */
    private $real;

    protected function setUp()
    {
        $this->real = m::mock(LoggerInterface::class);


    }

    public function testLogger()
    {
        $this->real->shouldReceive('debug')->once()->with('log message');

        $logger = new PsrAdapter($this->real);
        $logger->add('log message');
    }
}
