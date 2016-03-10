<?php

namespace Hyn\LetsEncrypt\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CertificateRequestCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('certificate:request')
            ->addArgument('hostnames', InputArgument::IS_ARRAY, 'Specify the hostnames you want to request a certificate for [example.com www.example.com ..].')
            ->addOption('http', false, InputOption::VALUE_OPTIONAL, 'Specify the public directory for this domain, solves the verification using file placement.')
            ->addOption('dns', false, InputOption::VALUE_OPTIONAL, 'Set to true, to solve verification using DNS, will wait for you to set the record.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
