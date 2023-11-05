<?php

namespace App\Repository\Post;

use App\Entity\Post\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }


    /**
     * Get all published posts
     * 
     * @return array
     */
    public function findPublished(): array
    {
        return $this->createQueryBuilder('p')
        ->where('p.state = :state')
        ->setParameter('state', Post::STATES[1])
        ->addOrderBy('p.createdAt', 'DESC')
        ->getQuery()
        ->getResult();
    }

}
