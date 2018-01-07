<?php

namespace AppBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;


class CustomListener implements ListenerInterface
{
    public function handle(GetResponseEvent $event)
    {
        dump($event);
        $request = $event->getRequest();
        dump($request);

        return new Response('qqqq');

    }
}