<?php

namespace App\Commands;

use RdKafka\Conf;
use RdKafka\Consumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class ConsumerCommand extends Command
{
    protected function configure()
    {
        $this->setName('consumer')
            ->setDescription('Produce message to a topic')
            ->addArgument('topic-name', InputArgument::REQUIRED, 'Enter the topic');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $topicName = $input->getArgument('topic-name');
        $output->writeln(sprintf('Topic is , %s', $topicName));

        $conf = new Conf();
        $conf->set('log_level', LOG_DEBUG);
        // $conf->set('debug', 'all');
        $rk = new Consumer($conf);
        $rk->addBrokers("kafka");

        $topic = $rk->newTopic($topicName);

        // The first argument is the partition to consume from.
        // The second argument is the offset at which to start consumption. Valid values
        // are: RD_KAFKA_OFFSET_BEGINNING, RD_KAFKA_OFFSET_END, RD_KAFKA_OFFSET_STORED.
        $topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

        $output->writeln('Started listening');

        while (true) {
            // The first argument is the partition (again).
            // The second argument is the timeout.
            $msg = $topic->consume(0, 1000);
            if (null === $msg) {
                continue;
            } elseif ($msg->err) {
                echo 'err :' . $msg->errstr() . " : still listening", "\n";
                continue;
            } else {
                echo $msg->payload, "\n";
            }
        }
    }
}