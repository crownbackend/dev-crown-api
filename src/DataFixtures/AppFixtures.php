<?php

namespace App\DataFixtures;

use App\Entity\Topic;
use App\Repository\ForumRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var ForumRepository
     */
    private $forumRepository;

    public function __construct(ForumRepository $forumRepository)
    {
        $this->forumRepository = $forumRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $forum = $this->forumRepository->findOneBy(["id" => 3]);

        for ($i = 0; $i < 100; $i++) {
            $topic = new Topic();
            $topic->setForum($forum);
            $topic->setTitle($faker->realText(200, 2));
            $topic->setDescription($faker->text);
            $topic->setClose(0);
            $topic->setResolve($faker->boolean);
            $topic->setCreatedAt($faker->dateTime);
            $manager->persist($topic);
        }

        $manager->flush();
    }
}
