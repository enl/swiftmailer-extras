<?php


namespace Enl\Swiftmailer\Test;

use Mockery as m;
use Enl\Swiftmailer\Mailer;

class MailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Swift_Transport|m\Mock
     */
    private $realtime;

    /**
     * @var \Swift_Spool|m\Mock
     */
    private $spool;

    /**
     * @var Mailer
     */
    private $mailer;

    protected function setUp()
    {
        $this->realtime = m::mock(\Swift_Transport::class);
        $this->spool = m::mock(\Swift_Spool::class);

        $this->mailer = new Mailer($this->realtime, $this->spool);
    }


    /**
     * Mailer should use realtime transport if `immediately` is called
     * @test
     */
    public function shouldUseRealtimeTransport()
    {
        $message = new \Swift_Message();
        $failed = [];

        $this->realtime->shouldReceive('isStarted')->once()->andReturn(false);
        $this->realtime->shouldReceive('start')->once();
        $this->realtime->shouldReceive('send')->withArgs([$message, $failed]);
        $this->spool->shouldNotReceive('queueMessage');

        $this->mailer->immediately()->send($message, $failed);
    }

    /**
     * Mailer should use spool if `immediately` is not called
     * @test
     */
    public function shouldUseSpool()
    {
        $message = new \Swift_Message();
        $failed = [];

        $this->realtime->shouldNotReceive('isStarted');
        $this->realtime->shouldNotReceive('start');
        $this->realtime->shouldNotReceive('send');
        $this->spool->shouldReceive('queueMessage')->once()->with($message);

        $this->mailer->send($message, $failed);
    }

    /**
     * @test
     */
    public function shouldUseRealtimeOnlyOnce()
    {
        $message = new \Swift_Message();
        $failed = [];

        $this->realtime->shouldReceive('isStarted')->once()->andReturn(false);
        $this->realtime->shouldReceive('start')->once();
        $this->realtime->shouldReceive('send')->withArgs([$message, $failed]);
        $this->spool->shouldReceive('queueMessage')->once()->with($message);

        $this->mailer->immediately()->send($message, $failed);
        $this->mailer->send($message, $failed);
    }
}
