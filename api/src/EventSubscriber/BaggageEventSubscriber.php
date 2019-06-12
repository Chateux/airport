<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Baggage;
use App\Entity\Reservation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BaggageEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['AddBaggageToUser', EventPriorities::POST_VALIDATE],
        ];
    }

    public function AddBaggageToUser(GetResponseForControllerResultEvent $event)
    {
        $reservation = $event->getControllerResult();

        if (!$reservation instanceof Reservation){
            return;
        }

        $passenger = $reservation->getPassenger();
        
        if(empty($passenger->getBaggage())) {
            $baggage = new Baggage();
            $baggage->setWeight(15);
            $passenger->setBaggage($baggage);
        }
    }
}
