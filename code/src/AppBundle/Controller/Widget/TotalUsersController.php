<?php

namespace AppBundle\Controller\Widget;

use AppBundle\Service\Elastic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TotalUsersController extends Controller
{
    /**
     * @Route("/dashboard/total_users", name="widget_total_users")
     */
    public function dataAction(Request $request)
    {
        $elasticService = $this->get('app.elastic');

        $queryResponse = $elasticService->getClient()->search($query = [
            'index' => $this->getParameter('elastic_index'),
            'type' => $this->getParameter('elastic_type'),
            'body' => [
                'size' => 0,
                'query' => [
                    'range' => $elasticService->getDateTimeFilter(
                        $request->query->get('period', Elastic::timeOptionToday)
                    ),
                ],
                'aggs' => [
                    'users' => [
                        'cardinality' => [
                            'field' => 'doc.ip_address.keyword',
                        ],
                    ],
                ],
            ],
        ]);

        if (empty($queryResponse['aggregations']['users']['value'])) {
            return $this->json([
                'value' => 0,
            ]);
        }

        return $this->json([
            'value' => $queryResponse['aggregations']['users']['value'],
        ]);
    }
}
