<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Impression;
use AppBundle\Service\Elastic;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ImpressionIndexerSubscriber implements EventSubscriber
{
    private $client;
    private $index;
    private $type;

    public function __construct(Elastic $client, $elasticIndex, $elasticType)
    {
        $this->client = $client->getClient();
        $this->index = $elasticIndex;
        $this->type = $elasticType;
    }

    public function getSubscribedEvents()
    {
        return [
            'postPersist',
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // you only want to act on "Impression" entity
        if ($entity instanceof Impression) {
            $this->indexImpression($entity);
        }
    }

    private function indexImpression(Impression $impression)
    {
        $document = [
            'event_date' => $impression->getEventDate()->format(DATE_ATOM),
            'user_agent_string' => $impression->getUserAgent(),
            'ip_address' => $impression->getIpAddress(),
            'destination' => $impression->getDestination(),
            'referrer' => $impression->getReferrer(),
        ];

        // store
        $this->client->index([
            'index' => $this->index,
            'type'  => $this->type,
            'id'    => $impression->getId(),
            'body'  => $document,
            'pipeline' => 'user_agent',
        ]);
    }
}
