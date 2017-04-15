<?php

namespace AppBundle\Controller\Widget;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SessionController extends Controller
{
    /**
     * @Route("/dashboard/session", name="widget_session")
     */
    public function dataAction()
    {
        return $this->json([
            'value' => rand(40, 100),
        ]);
    }
}
