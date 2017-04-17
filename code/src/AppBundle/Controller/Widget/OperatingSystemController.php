<?php

namespace AppBundle\Controller\Widget;

use AppBundle\Service\Elastic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OperatingSystemController extends Controller
{
    /**
     * @Route("/dashboard/operating_system", name="widget_operating_system")
     */
    public function dataAction(Request $request)
    {
        $elasticSerivce = $this->get('app.elastic');

        $queryResponse = $elasticSerivce->getClient()->search($query = [
            'index' => $this->getParameter('elastic_index'),
            'type' => $this->getParameter('elastic_type'),
            'body' => [
                'size' => 0,
                'aggs' => [
                    'os' => [
                        'range' => $elasticSerivce->getDateTimeFilter($request->query->get('period', Elastic::timeOptionToday)),
                        'aggs' => [
                            'breakdown' => [
                                'terms' => [
                                    'field' => 'user_agent.os_name.keyword',
                                    'size' => 10,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $data = [];

        if (empty($queryResponse['aggregations']['os']['buckets'][0]['breakdown']['buckets'])) {
            return $this->json($data);
        }

        foreach ($queryResponse['aggregations']['os']['buckets'][0]['breakdown']['buckets'] as $bucket) {
            $data[$bucket['key']] = $bucket['doc_count'];
        }

        return $this->json($data);
    }
}
