<?php

namespace Hyn\LetsEncrypt\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CertificateRequestCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('certificate:request')
            ->addArgument('hostnames', InputArgument::IS_ARRAY, 'Specify the hostnames you want to request a certificate for')
            ->addOption('http01', InputOption::VALUE_OPTIONAL, 'Specify the public directory for this domain, solves the verification using file placement')
            ->addOption('dns01', InputOption::VALUE_OPTIONAL, 'Set to true, to solve verification using DNS, will wait for you to set the record.');
    }
}
