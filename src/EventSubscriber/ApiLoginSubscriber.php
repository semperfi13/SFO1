<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ApiLoginSubscriber implements EventSubscriberInterface
{
    private User $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function onKernelRequest(RequestEvent $event): void
    {
        $event->getRequest();
        $request = $event->getRequest();
        $path = $request->getPathInfo();
        if (preg_match("/^\/api/", $path) && preg_match("/^\/api/login", $path) == 0) {
            $apiToken = $request->headers->get("X-AUTH-TOKEN", 0);
            $user = $this->usRepo->findBy(["apiToken" => $apiToken]);
            if (!$user) {
                $event->setResponse(new JsonResponse('Utilisateur non authentifié', 401));
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
