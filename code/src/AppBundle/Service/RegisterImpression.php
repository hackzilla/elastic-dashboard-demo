<?php

namespace AppBundle\Service;

use AppBundle\Entity\Impression;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RegisterImpression
 *
 * @package AppBundle\Service
 */
class RegisterImpression
{
    private $manager;
    private $requestStack;

    public function __construct(RequestStack $requestStack, EntityManager $manager)
    {
        $this->manager = $manager;
        $this->requestStack = $requestStack;
    }

    /**
     * Capture impression and store in db
     */
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
        $impression->setDestination($this->stripFrontController($request->server->get('REQUEST_URI')));
        $impression->setReferrer($this->stripFrontController($referrer));
        $impression->setUserAgent($request->server->get('HTTP_USER_AGENT'));

        $this->manager->persist($impression);
        $this->manager->flush();
    }

    /**
     * Remove front controller.
     * e.g. /app.php or /app_dev.php
     *
     * @param string $uri
     *
     * @return string
     */
    private function stripFrontController($uri)
    {
        if (preg_match('|/app(_.*[^.])?\.php(.*)|', $uri, $matches)) {
            return $matches[2];
        }

        return $uri;
    }
}
