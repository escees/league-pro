<?php

namespace App\DataFixtures;

use App\Entity\FootballMatch;
use App\Entity\MatchDetails;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MatchFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $match1 = new FootballMatch();
        $match1->setHomeTeam($this->getReference('team-1'));
        $match1->setAwayTeam($this->getReference('team-2'));
        $match1->setDescription('match description 1');
        $match1->setStartDate(new \DateTime('-1 day'));
//        $match1->setMatchDetails($this->getReference('match-details-1'));
        $this->addReference('match-1', $match1);

        $manager->persist($match1);

        $match2 = new FootballMatch();
        $match2->setHomeTeam($this->getReference('team-3'));
        $match2->setAwayTeam($this->getReference('team-4'));
        $match2->setDescription('match description 2');
        $match2->setStartDate(new \DateTime('-2 day'));
//        $match2->setMatchDetails($this->getReference('match-details-2'));
        $this->addReference('match-2', $match2);

        $manager->persist($match2);

        $match3 = new FootballMatch();
        $match3->setHomeTeam($this->getReference('team-1'));
        $match3->setAwayTeam($this->getReference('team-5'));
        $match3->setDescription('match description 3');
        $match3->setStartDate(new \DateTime('-3 day'));
//        $match1->setMatchDetails($this->getReference('match-details-3'));
        $this->addReference('match-3', $match3);

        $manager->persist($match3);

        $match4 = new FootballMatch();
        $match4->setHomeTeam($this->getReference('team-2'));
        $match4->setAwayTeam($this->getReference('team-4'));
        $match4->setDescription('match description 4');
        $match4->setStartDate(new \DateTime('-4 day'));
//        $match1->setMatchDetails($this->getReference('match-details-4'));
        $this->addReference('match-4', $match4);

        $manager->persist($match4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TeamFixtures::class,
//            MatchDetailsFixtures::class,
        ];
    }
}
