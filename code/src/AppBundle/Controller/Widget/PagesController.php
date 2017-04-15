<?php

namespace AppBundle\Controller\Widget;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    /**
     * @Route("/dashboard/pages", name="widget_pages")
     */
    public function dataAction()
    {
        return $this->json([
            'html/a' => rand(40, 100),
            'html/b' => rand(40, 100),
            'html/c' => rand(40, 100),
        ]);
    }
}
