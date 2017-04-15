<?php

namespace AppBundle\Controller\Widget;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TotalUsersController extends Controller
{
    /**
     * @Route("/dashboard/total_users", name="widget_total_users")
     */
    public function dataAction()
    {
        return $this->json([
            'value' => rand(40, 100),
        ]);
    }
}
