<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HtmlController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/html/{path}", name="html", requirements={"path"=".*"})
     */
    public function htmlAction(Request $request, $path = 'homepage')
    {
        $this->get('register_impression')->impression($request);
        $paths = $this->get('routes')->getPaths();

        return $this->render('html/page.html.twig', [
            'page' => $path,
            'paths' => $paths,
        ]);
    }
}
