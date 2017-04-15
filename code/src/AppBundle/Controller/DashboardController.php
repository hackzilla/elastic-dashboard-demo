<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    const timeOption1Min = 1;
    const timeOption5Min = 2;
    const timeOption30Min = 3;
    const timeOption60Min = 4;
    const timeOptionToday = 10;
    const timeOptionYesterday = 20;

    static $timeOptions = [
         self::timeOption1Min => '1 min',
         self::timeOption5Min => '5 min',
         self::timeOption30Min => '30 min',
         self::timeOption60Min => '60 min',
         self::timeOptionToday => 'today',
         self::timeOptionYesterday => 'yesterday',
    ];

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('dashboard/index.html.twig', [
            'timeOptions' => self::$timeOptions,
        ]);
    }

}
