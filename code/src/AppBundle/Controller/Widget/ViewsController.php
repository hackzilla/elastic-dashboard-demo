<?php

namespace AppBundle\Controller\Widget;

use AppBundle\Service\Elastic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ViewsController extends Controller
{
    /**
     * @Route("/dashboard/views", name="widget_views")
     */
    public function dataAction(Request $request)
    {
        $elasticService = $this->get('app.elastic');
        $timeOption = $request->query->get('period', Elastic::timeOptionToday);

        $queryResponse = $elasticService->getClient()->search($query = [
            'index' => $this->getParameter('elastic_index'),
            'type' => $this->getParameter('elastic_type'),
            'body' => [
                'size' => 0,
                'query' => [
                    'range' => $elasticService->getDateTimeFilter($timeOption, false),
                ],
            ],
        ]);

        return $this->json([
            'value' => $queryResponse['hits']['total'],
        ]);
    }
}
