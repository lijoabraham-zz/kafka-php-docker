<?php

namespace App\Commands;

use RdKafka\Conf;
use RdKafka\Producer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class ProducerCommand extends Command
{
    protected function configure()
    {
        $this->setName('producer')
            ->setDescription('Produce message to a topic')
            ->addArgument('topic-name', InputArgument::REQUIRED, 'Enter the topic');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $topicName = $input->getArgument('topic-name');
        $output->writeln(sprintf('Topic is , %s', $topicName));

        $conf = new Conf();
        // $conf->set('log_level', LOG_DEBUG);
        // $conf->set('debug', 'all');
        $rk = new Producer($conf);
        $rk->addBrokers("kafka");

        $topic = $rk->newTopic($topicName);

        for ($i = 0; $i < 10; $i++) {
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, "Message " . rand(1000, 100000));
            $rk->poll(0);
        }

        while ($rk->getOutQLen() > 0) {
            $rk->poll(50);
        }
    }
}