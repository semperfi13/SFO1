<?php

namespace App\EventSubscriber;

use App\Entity\Historiqueconnexion;
use App\Repository\HistoriqueconnexionRepository;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private HistoriqueconnexionRepository $hcRepo;
    private RequestStack $request;

    public function __construct(HistoriqueconnexionRepository $hcR, RequestStack $rq)
    {
        $this->hcRepo = $hcR;
        $this->request = $rq;
    }


    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        /**
         *@var User 
         **/

        $user = $event->getAuthenticationToken()->getUser();
        $url = $this->request->getCurrentRequest()->getPathInfo();
        //dd($this->request);

        $ip = $this->request->getCurrentRequest()->server->get("REMOTE_ADDR");
        $hc = new Historiqueconnexion();
        $hc->setDateconnexion(new DateTime())
            ->setEmail($user->getEmail())
            ->setIp($ip)
            ->setUrl($url);
        $user->setLastconnexion(new DateTime());
        $this->hcRepo->add($hc, true);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
