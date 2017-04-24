<?php

namespace AppBundle\Controller\Widget;

use AppBundle\Service\Elastic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SessionController extends Controller
{
    /**
     * @Route("/dashboard/session", name="widget_session")
     */
    public function dataAction(Request $request)
    {
        $elasticService = $this->get('app.elastic');

        $queryResponse = $elasticService->getClient()->search(
            $query = [
                'index' => $this->getParameter('elastic_index'),
                'type'  => $this->getParameter('elastic_type'),
                'body'  => [
                    'size' => 0,
                    'query' => [
                        'range' => $elasticService->getDateTimeFilter(
                            $request->query->get('period', Elastic::timeOptionToday)
                        ),
                    ],
                    'aggs' => [
                        'users' => [
                            'terms' => [
                                'field' => 'ip_address.keyword',
                            ],
                            'aggs'  => [
                                'browsers' => [
                                    'terms' => [
                                        'field' => 'user_agent.keyword',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        if (empty($queryResponse['aggregations']['users']['buckets'])) {
            return $this->json([
                'value' => 0,
            ]);
        }

        $count = 0;

        foreach ($queryResponse['aggregations']['users']['buckets'] as $user) {
            $count += count($user['browsers']['buckets']);
        }

        return $this->json([
            'value' => $count,
        ]);
    }
}
