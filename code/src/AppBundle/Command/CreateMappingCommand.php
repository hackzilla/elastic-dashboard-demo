<?php

namespace AppBundle\Command;

use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateMappingCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:elastic:create-mapping')
            ->setDescription('Create Elastic Search Mapping')
            ->setHelp(
                <<<EOF
                The <info>app:elastic:create-mapping</info> command will create the elastic search mappings if they don't exist.
EOF
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getContainer()->get('app.elastic')->getClient();
        $index = $this->getContainer()->getParameter('elastic_index');
        $type = $this->getContainer()->getParameter('elastic_type');

        $params = [
            'index' => $index,
            'type'  => $type,
            'body'  => [
                $type => [
                    'properties' => [
                        'event_date' => [
                            'type' => 'date',
                        ],
                        'agent' => [
                            'type' => 'string',
                        ],
                        'ip_address' => [
                            'type' => 'ip',
                        ],
                        'destination' => [
                            'type' => 'string',
                            'index' => 'not_analyzed',
                        ],
                        'referrer' => [
                            'type' => 'string',
                            'index' => 'not_analyzed',
                        ],
                    ],
                ],
            ],
            'update_all_types' => true,
        ];

        try {
            $response = $client->indices()->putMapping($params);
            $output->writeln('Mapping created: '.$index.'/'.$type);
        } catch (BadRequest400Exception $e) {
            $output->writeln('Failed to create mapping: '.$e->getMessage());
            $output->writeln(print_r($params, 1));
        }
    }
}
