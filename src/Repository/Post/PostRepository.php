<?php

namespace App\Repository\Post;

use App\Entity\Post\Category;
use App\Entity\Post\Post;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function __construct(
        ManagerRegistry $registry, 
        private PaginatorInterface $paginatorInterface
    ) {
        parent::__construct($registry, Post::class);
    }


    /**
     * Get all published posts
     * 
     * @param int $page
     * @return PaginationInterface
     */
    public function findPublished(int $page, ?Category $category = null): PaginationInterface
    {
        $data =  $this->createQueryBuilder('p')
        ->join('p.categories', 'c')
        ->where('p.state = :state')
        ->setParameter('state', Post::STATES[1])
        ->addOrderBy('p.createdAt', 'DESC');
       
        if(isset($category)) {
            $data = $data
                ->andWhere(':category in (c)')
                ->setParameter('category', $category);
        }

        $data ->getQuery()
        ->getResult();

        $posts = $this->paginatorInterface->paginate($data, $page, 9);

        return $posts;

    }

}
