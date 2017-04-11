<?php

namespace AppBundle\Service;

use AppBundle\Entity\Impression;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

class RegisterImpression
{
    private $manager;
    private $requestStack;

    public function __construct(RequestStack $requestStack, EntityManager $manager)
    {
        $this->manager = $manager;
        $this->requestStack = $requestStack;
    }

    public function impression()
    {
        $request = $this->requestStack->getCurrentRequest();

        $impression = new Impression();
        $referrer = $request->server->get('HTTP_REFERER');

        if ($referrer) {
            $referrer = substr($referrer, strpos($referrer, '/', 10));
        }

        $impression->setEventDate(\DateTime::createFromFormat('U', $request->server->get('REQUEST_TIME')));
        $impression->setIpAddress($request->getClientIp());
        $impression->setDestination($request->server->get('REQUEST_URI'));
        $impression->setReferrer($referrer);
        $impression->setUserAgent($request->server->get('HTTP_USER_AGENT'));

        $this->manager->persist($impression);
        $this->manager->flush();
    }
}
