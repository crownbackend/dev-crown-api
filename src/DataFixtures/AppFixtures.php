<?php

namespace App\DataFixtures;

use App\Entity\Response;
use App\Entity\Topic;
use App\Repository\ForumRepository;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var ForumRepository
     */
    private $forumRepository;
    /**
     * @var TopicRepository
     */
    private $topicRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ForumRepository $forumRepository, TopicRepository $topicRepository,
                                UserRepository $userRepository)
    {
        $this->forumRepository = $forumRepository;
        $this->topicRepository = $topicRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $topic = $this->topicRepository->findOneBy(["id" => 342]);
        $user = $this->userRepository->findOneBy(["id" => 1]);

        for ($i = 0; $i < 15; $i++) {
            $response = new Response();
            $response->setContent($faker->text(500));
            $response->setCreatedAt($faker->dateTime);
            $response->setTopic($topic);
            $response->setUser($user);
            $manager->persist($response);
        }

//        $forum = $this->forumRepository->findOneBy(["id" => 1]);
//
//        for ($i = 0; $i < 100; $i++) {
//            $topic = new Topic();
//            $topic->setForum($forum);
//            $topic->setTitle($faker->realText(200, 2));
//            $topic->setDescription($faker->randomHtml());
//            $topic->setClose(0);
//            $topic->setResolve($faker->boolean);
//            $topic->setCreatedAt($faker->dateTime);
//            $topic->setUser($user);
//            $manager->persist($topic);
//        }

        $manager->flush();
    }
}
