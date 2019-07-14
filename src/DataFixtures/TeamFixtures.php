<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TeamFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $team1 = new Team();
        $team1->setName('Wariaty');
        $team1->setDescription('description of team 1');
        $team1->setDraws(2);
        $team1->setLoses(0);
        $team1->setWins(5);
        $team1->setWinsAfterExtraTime(1);
        $team1->addPlayer($this->getReference('player-1'));
        $team1->addPlayer($this->getReference('player-2'));
        $this->addReference('team-1', $team1);

         $manager->persist($team1);

        $team2 = new Team();
        $team2->setName('Patole');
        $team2->setDescription('description of team 2');
        $team2->setDraws(4);
        $team2->setLoses(4);
        $team2->setWins(2);
        $team2->setWinsAfterExtraTime(1);
        $team2->addPlayer($this->getReference('player-3'));
        $this->addReference('team-2', $team2);

        $manager->persist($team2);

        $team3 = new Team();
        $team3->setName('Lwy');
        $team3->setDescription('description of team 3');
        $team3->setDraws(1);
        $team3->setLoses(3);
        $team3->setWins(2);
        $team3->setWinsAfterExtraTime(1);
        $team3->addPlayer($this->getReference('player-4'));
        $this->addReference('team-3', $team3);

        $manager->persist($team3);

        $team4 = new Team();
        $team4->setName('KM Efektowni');
        $team4->setDescription('description of team 4');
        $team4->setDraws(6);
        $team4->setLoses(4);
        $team4->setWins(1);
        $team4->setWinsAfterExtraTime(1);
        $team4->addPlayer($this->getReference('player-5'));
        $this->addReference('team-4', $team4);

        $manager->persist($team4);

        $team5 = new Team();
        $team5->setName('Mośki');
        $team5->setDescription('description of team 5');
        $team5->setDraws(7);
        $team5->setLoses(4);
        $team5->setWins(0);
        $team5->setWinsAfterExtraTime(1);
        $team5->addPlayer($this->getReference('player-6'));
        $team5->addPlayer($this->getReference('player-7'));
        $this->addReference('team-5', $team5);

        $manager->persist($team5);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlayerFixtures::class,
        ];
    }
}
