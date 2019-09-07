<?php

namespace App\DataFixtures;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PlayerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $player1 = new Player();
        $player1->setName('Artur Warzycha');
        $player1->setAppearances(30);
//        $player1->setTeam($this->getReference('team-1'));
        $this->addReference('player-1', $player1);

        $manager->persist($player1);

        $player2 = new Player();
        $player2->setName('Kamil Kosowski');
        $player2->setAppearances(40);
//        $player1->setTeam($this->getReference('team-1'));
        $this->addReference('player-2', $player2);

        $manager->persist($player2);

        $player3 = new Player();
        $player3->setName('Marek Citko');
        $player3->setAppearances(20);
//        $player1->setTeam($this->getReference('team-2'));
        $this->addReference('player-3', $player3);

        $manager->persist($player3);

        $player4 = new Player();
        $player4->setName('Josep Guardiola');
        $player4->setAppearances(60);
//        $player1->setTeam($this->getReference('team-3'));
        $this->addReference('player-4', $player4);

        $manager->persist($player4);

        $player5 = new Player();
        $player5->setName('Luiz Nazario De Lima Ronaldo');
        $player5->setAppearances(44);
//        $player1->setTeam($this->getReference('team-4'));
        $this->addReference('player-5', $player5);

        $manager->persist($player5);

        $player6 = new Player();
        $player6->setName('Ryan Giggs');
        $player6->setAppearances(87);
//        $player1->setTeam($this->getReference('team-5'));
        $this->addReference('player-6', $player6);

        $manager->persist($player6);

        $player7 = new Player();
        $player7->setName('Ronaldinho Gaucho');
        $player7->setAppearances(89);
//        $player1->setTeam($this->getReference('team-5'));
        $this->addReference('player-7', $player7);

        $manager->persist($player7);

        $manager->flush();
    }

//    public function getDependencies()
//    {
//        return [
//            TeamFixtures::class,
//        ];
//    }
}
