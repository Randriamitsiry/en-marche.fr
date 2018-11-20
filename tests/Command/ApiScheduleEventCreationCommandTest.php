<?php

namespace Tests\AppBundle\Command;

use AppBundle\DataFixtures\ORM\LoadAdherentData;
use AppBundle\DataFixtures\ORM\LoadEventData;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Tests\AppBundle\Controller\ControllerTestTrait;

/**
 * @group command
 */
class ApiScheduleEventCreationCommandTest extends WebTestCase
{
    use ControllerTestTrait;

    public function testCommand(): void
    {
        $output = $this->runCommand('app:sync:events');

        $this->assertContains('Starting synchronization.', $output);
        $this->assertContains('21/21', $output);
        $this->assertContains('Successfully scheduled for synchronization!', $output);
    }

    public function setUp()
    {
        $this->loadFixtures([
            LoadAdherentData::class,
            LoadEventData::class,
        ]);

        parent::setUp();
    }

    public function tearDown()
    {
        $this->kill();

        parent::tearDown();
    }
}
