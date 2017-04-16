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
