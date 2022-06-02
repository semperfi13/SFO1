<?php

namespace App\twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class isActiveExtension extends AbstractExtension
{

    private $requestStack;
    public function __construct(RequestStack $rq)
    {
        $this->requestStack = $rq;
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('isActive', [$this, 'isActive'])
        ];
    }

    public function isActive($liens = []): string
    {
        $routeActuelle = $this->requestStack->getCurrentRequest()->get("_route");
        if (in_array($routeActuelle, $liens)) {
            return "active";
        } else {
            return '';
        }
    }
}
