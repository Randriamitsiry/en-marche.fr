<?php

namespace AppBundle\Controller\Api;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use AppBundle\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class IdeasController extends Controller
{
    public function myIdeasContributedAction(IdeaRepository $ideaRepository, UserInterface $user, Request $request): Paginator
    {
        $page = (int) $request->query->get('page', 1);
        $itemPerPage = $this->getParameter('api_platform.collection.pagination.items_per_page');

        return $ideaRepository->getAdherentContributedIdeas($user, $page, $itemPerPage);
    }
}
