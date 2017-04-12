<?php

namespace AppBundle\Command;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreatePipelineCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:elastic:create-pipeline')
            ->setDescription('Create Elastic Search Pipeline')
            ->setHelp(
                <<<EOF
                The <info>app:elastic:create-pipeline</info> command will create the elastic search pipeline if they don't exist.
EOF
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Client $client */
        $client = $this->getContainer()->get('app.elastic')->getClient();

        $params = [
            "id" => "user_agent",
            "body" => [
                "description" => "Add user agent information",
                "processors"  => [
                    [
                        "user_agent" => [
                            "field" => "user_agent",
                        ],
                    ],
                ],
            ],
        ];

        try {
            $response = $client->ingest()->putPipeline($params);
            $output->writeln('Pipeline created.');
        } catch (BadRequest400Exception $e) {
            $output->writeln('Failed to create pipeline: '.$e->getMessage());
            $output->writeln(print_r($params, 1));
        }
    }
}
