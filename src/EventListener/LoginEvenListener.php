<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class LoginEventListener

{
    public function onKernelRequest(RequestEvent $event)
    {
        dd($event);
    }
}
