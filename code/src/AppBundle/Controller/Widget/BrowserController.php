<?php

namespace AppBundle\Controller\Widget;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrowserController extends Controller
{
    /**
     * @Route("/dashboard/browser", name="widget_browser")
     */
    public function dataAction()
    {
        return $this->json([
            'Safari' => rand(40, 100),
            'IE' => rand(40, 100),
            'Chrome' => rand(40, 100),
        ]);
    }
}
