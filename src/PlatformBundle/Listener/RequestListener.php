<?php

namespace PlatformBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        //dump($request->server->get('REMOTE_ADDR'));

        /*if ($request->server->get('REMOTE_ADDR') == '127.0.0.1') {
            $response = new Response("hello, message here");
            //return $response->setStatusCode(403);
            $event->setResponse($response);
            throw new AccessDeniedHttpException('access denied');
        }*/
    }
}