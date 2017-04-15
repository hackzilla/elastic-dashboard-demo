<?php

namespace AppBundle\Controller\Widget;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OperatingSystemController extends Controller
{
    /**
     * @Route("/dashboard/operating_system", name="widget_operating_system")
     */
    public function dataAction()
    {
        return $this->json([
            'Windows' => rand(40, 100),
            'MacOS' => rand(40, 100),
        ]);
    }
}
