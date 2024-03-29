<?php 

namespace App\EventSubscriber;

use App\Repository\Post\CategoryRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class DropdownCategoriesSubscriber implements EventSubscriberInterface
{
    const ROUTES = ['post.index', 'category.index'];

    public function __construct(
        private CategoryRepository $categoryRepository,
        private Environment $twig
    )
    {
    }

    public function injectGlobalVariables(RequestEvent $event): void
        {
            $route = $event->getRequest()->get('_route');

            if(in_array($route, self::ROUTES)) {
                $categories = $this->categoryRepository->findAll();
                $this->twig->addGlobal('allCategories', $categories);
            }
        }

    public static function getSubscribedEvents(): array
    {

        return [
            KernelEvents::REQUEST => 'injectGlobalVariables'
        ];
    }
}