<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApiController extends Controller
{
    /**
     * @Route("/api/{path}", name="api", requirements={"path"=".*"})
     */
    public function apiAction(Request $request)
    {
        $this->get('register_impression')->impression($request);

        $urls = [];

        foreach ($this->get('routes')->getPaths() as $path) {
            $urls[] = $this->get('router')->generate('api', ['path' => $path], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return new JsonResponse([
            'urls' => $urls,
        ]);
    }
}
