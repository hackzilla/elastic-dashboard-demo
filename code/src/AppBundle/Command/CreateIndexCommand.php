<?php

namespace AppBundle\Command;

use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateIndexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:elastic:create-index')
            ->setDescription('Create Elastic Search Index')
            ->setHelp(
                <<<EOF
                The <info>app:elastic:create-index</info> command will create the elastic search indexes if they do not exist.
EOF
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getContainer()->get('app.elastic')->getClient();
        $index = $this->getContainer()->getParameter('elastic_index');

        try {
            $response = $client->indices()->create([
                'index' => $index,
                'body' => [
                    'settings' => [
                        'number_of_shards' => 2,
                        'number_of_replicas' => 0,
                    ],
                ],
            ]);
            $output->writeln('Index created: '.$index);
        } catch (BadRequest400Exception $e) {
            $output->writeln('Failed to create index [' . $index . ']: '.$e->getMessage());
        }
    }
}
