<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends ContainerAwareCommand
{
    private $ch;

    public function __construct($name = null)
    {
        $this->ch = curl_init();

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('app:generate:impressions')
            ->setDescription('Generate Impressions')
            ->setHelp("This command generates fake impressions for the dashboard")
            ->addOption(
                'clients',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, will change the maximum number of clients to simulate',
                100
            )
//            ->addOption(
//                'concurrent',
//                null,
//                InputOption::VALUE_OPTIONAL,
//                'If set, will change the maximum concurrent clients',
//                5
//            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $faker = \Faker\Factory::create();

        $totalUsers = (int)$input->getOption('clients');
        $pages = 0;

        while ($totalUsers) {
            $userAgent = $faker->userAgent;
            $url = "http://127.0.0.1:8888/app.php/api/";
            $refer = '';

            while ($rnd = rand(0, 3)) {
                $response = json_decode($this->getUrl($url, $userAgent, $refer));
                $pages++;

                if (is_null($response)) {
                    break;
                }

                $refer = $url;
                $url = $response->urls[rand(0, count($response->urls) -1)];
            }

            $totalUsers--;
        }

        $output->writeln("Crawled {$pages} pages.");
    }

    private function getUrl($url, $userAgent, $refer)
    {
//        return '{
//    "urls": [
//        "http://127.0.0.1:8888/app.php/api/",
//        "http://127.0.0.1:8888/app.php/api/a",
//        "http://127.0.0.1:8888/app.php/api/b",
//        "http://127.0.0.1:8888/app.php/api/c",
//        "http://127.0.0.1:8888/app.php/api/d"
//    ]
//}';

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_REFERER, $refer);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($this->ch);
    }
}
