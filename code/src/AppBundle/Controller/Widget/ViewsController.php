<?php

namespace AppBundle\Controller\Widget;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewsController extends Controller
{
    /**
     * @Route("/dashboard/views", name="widget_views")
     */
    public function dataAction()
    {
        return $this->json([
            'value' => rand(40, 100),
        ]);
    }
}
