<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\MatchDetails;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MatchDetailsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $matchDetails1 = new MatchDetails();
        $matchDetails1->setHomeTeamGoals(1);
        $matchDetails1->setAwayTeamGoals(2);
        $matchDetails1->setFootballMatch($this->getReference('match-1'));
        $this->addReference('match-details-1', $matchDetails1);

        $manager->persist($matchDetails1);

        $matchDetails2 = new MatchDetails();
        $matchDetails2->setHomeTeamGoals(1);
        $matchDetails2->setAwayTeamGoals(0);
        $matchDetails2->setFootballMatch($this->getReference('match-2'));
        $this->addReference('match-details-2', $matchDetails2);

        $manager->persist($matchDetails2);

        $matchDetails3 = new MatchDetails();
        $matchDetails3->setHomeTeamGoals(5);
        $matchDetails3->setAwayTeamGoals(2);
        $matchDetails3->setFootballMatch($this->getReference('match-3'));
        $this->addReference('match-details-3', $matchDetails3);

        $manager->persist($matchDetails3);

        $matchDetails4 = new MatchDetails();
        $matchDetails4->setHomeTeamGoals(0);
        $matchDetails4->setAwayTeamGoals(2);
        $matchDetails4->setFootballMatch($this->getReference('match-4'));
        $this->addReference('match-details-4', $matchDetails4);

        $manager->persist($matchDetails4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MatchFixtures::class,
        ];
    }
}
