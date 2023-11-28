<?php 

namespace App\Controller;

use App\Entity\Post\Post;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like/article/{id}', name: 'like.post')]
    #[IsGranted('ROLE_USER')]
    public function like(Post $post, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        if ($post->isLikedByUser($user)) {
            $post->removeLike($user);
            $manager->flush();

            return $this->json([
                'message' => 'Le like à bien été supprimé',
                'nbLikes' => $post->howManyLikes()
            ]);
        } 
        
        $post->addLike($user);
        $manager->flush();
        
        return $this->json([
            'message' => 'Le like à bien été ajouté',
            'nbLikes' => $post->howManyLikes()
        ]);
    }
}