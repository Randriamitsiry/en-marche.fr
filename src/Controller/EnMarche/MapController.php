<?php

namespace AppBundle\Controller\EnMarche;

use AppBundle\Controller\CanaryControllerTrait;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\Committee;
use AppBundle\Entity\Event;
use AppBundle\Entity\EventCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    use CanaryControllerTrait;

    /**
     * @Route("/le-mouvement/la-carte", name="map_committees")
     * @Method("GET")
     */
    public function committeesAction()
    {
        $this->disableInProduction();

        $doctrine = $this->getDoctrine();

        return $this->render('map/committees.html.twig', [
            'userCount' => $doctrine->getRepository(Adherent::class)->countAdherents(),
            'eventCount' => $doctrine->getRepository(Event::class)->countElements(),
            'committeeCount' => $doctrine->getRepository(Committee::class)->countElements(),
        ]);
    }

    // Unlike the other actions of this class the route of this action is defined in the config to prevent another route to match his path
    public function eventsAction()
    {
        $doctrine = $this->getDoctrine();

        return $this->render('map/events.html.twig', [
            'eventCount' => $doctrine->getRepository(Event::class)->countUpcomingEvents(),
            'categories' => $doctrine->getRepository(EventCategory::class)->findAllEnabledOrderedByName(),
        ]);
    }
}
