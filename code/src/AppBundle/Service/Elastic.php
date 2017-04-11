<?php

namespace AppBundle\Service;

use Elasticsearch\ClientBuilder;

class Elastic
{
    private $client;

    public function __construct($host, $port)
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$host . ':' . $port])
            ->build()
        ;
    }

    public function getClient()
    {
        return $this->client;
    }
}
