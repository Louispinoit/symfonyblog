<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post\Comment;
use App\Repository\UserRepository;
use App\Repository\Post\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly UserRepository $userRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = $this->userRepository->findAll();
        $posts = $this->postRepository->findAll();

        foreach ($posts as $post) {
            for ($i = 0; $i < mt_rand(0, 15); $i++) {
              $comment = new Comment();

                $comment->setContent($faker->realText(150))
                        ->setIsApproved(mt_rand(0, 3) === 0 ? false : true)
                        ->setAuthor($users[mt_rand(0, count($users) - 1)])
                        ->setPost($post);

                $manager->persist($comment);
                $post->addComments($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PostFixtures::class
        ];
    }
}
