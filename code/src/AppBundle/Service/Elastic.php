<?php

namespace AppBundle\Service;

use Elasticsearch\ClientBuilder;

/**
 * Class Elastic
 *
 * @package AppBundle\Service
 */
class Elastic
{
    private $client;

    /**
     * Elastic constructor.
     *
     * @param string $host
     * @param int $port
     */
    public function __construct($host, $port)
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$host . ':' . $port])
            ->build()
        ;
    }

    /**
     * @return \Elasticsearch\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
