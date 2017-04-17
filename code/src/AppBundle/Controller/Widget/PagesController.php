<?php

namespace AppBundle\Controller\Widget;

use AppBundle\Service\Elastic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends Controller
{
    /**
     * @Route("/dashboard/pages", name="widget_pages")
     */
    public function dataAction(Request $request)
    {
        $elasticService = $this->get('app.elastic');

        $queryResponse = $elasticService->getClient()->search($query = [
            'index' => $this->getParameter('elastic_index'),
            'type' => $this->getParameter('elastic_type'),
            'body' => [
                'size' => 0,
                'aggs' => [
                    'pages' => [
                        'range' => $elasticService->getDateTimeFilter($request->query->get('period', Elastic::timeOptionToday)),
                        'aggs' => [
                            'breakdown' => [
                                'terms' => [
                                    'field' => 'doc.destination.keyword',
                                    'size' => 10,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $data = [];

        if (empty($queryResponse['aggregations']['pages']['buckets'][0]['breakdown']['buckets'])) {
            return $this->json($data);
        }

        foreach ($queryResponse['aggregations']['pages']['buckets'][0]['breakdown']['buckets'] as $bucket) {
            $data[$bucket['key']] = $bucket['doc_count'];
        }

        return $this->json($data);
    }
}
