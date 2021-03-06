<?php

namespace Tests\Entity\User;

use App\Entity\User\ActivationLink;

class ActivationLinkTest extends \PHPUnit\Framework\TestCase {
    public function testEntity() {
        $activationLink =
            (new ActivationLink())
            ->setId(3)
            ->setHash('ugreg85dfqsd')
            ->setCreatedAt(new \DateTime())
        ;
        $this->assertEquals(3, $activationLink->getId());
        $this->assertEquals('ugreg85dfqsd', $activationLink->getHash());
        $this->assertInstanceOf('DateTime', $activationLink->getCreatedAt());
    }
}
