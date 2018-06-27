<?php

namespace Tests\Controller\Project;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use App\DataFixtures\ORM\User\LoadActivationLinkData;
use App\DataFixtures\ORM\User\LoadProductOwnerData;
use App\DataFixtures\ORM\LoadOrganizationData;
use App\DataFixtures\ORM\Project\LoadDetailsData;
use App\DataFixtures\ORM\Project\LoadProjectData;
use App\DataFixtures\ORM\Project\LoadPollData;

class PollControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures([
            LoadActivationLinkData::class,
            LoadOrganizationData::class,
            LoadProductOwnerData::class,
            LoadProjectData::class,
            LoadPollData::class,
            LoadDetailsData::class
        ]);
    }
    
    public function testGetPoll()
    {
        $client = $this->makeClient();
        $client->request('GET', '/projects/paradis-sauvage/polls/999');
        
        $this->assertStatusCode(404, $client);
        
        $crawler = $client->request('GET', '/projects/paradis-sauvage/polls/1');
        
        $this->assertStatusCode(200, $client);
        
        $this->assertContains('Paradis sauvage', $crawler->filter('#poll-infos > header')->text());
        $this->assertContains('14/06/2018', $crawler->filter('#poll-infos > section:last-child')->text());
    }
    
    public function testCreatePoll()
    {
        $client = $this->makeClient();
        $client->request('POST', '/projects/paradis-sauvage/polls');
        
        $this->assertStatusCode(302, $client);
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
        
        $client = $this->makeClient(true);
        $client->request('POST', '/projects/doctrine-backup-bundle/polls');
        
        $this->assertStatusCode(403, $client);
        
        $client->request('POST', '/projects/site-officiel-developtech/polls');
        
        $this->assertStatusCode(302, $client);
        $this->assertTrue($client->getResponse()->isRedirect('/projects/site-officiel-developtech/polls/3'));
    }
}