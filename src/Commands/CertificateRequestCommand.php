<?php

namespace Hyn\LetsEncrypt\Commands;

use Hyn\LetsEncrypt\Solvers\Http01Solver;
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
            ->addArgument('hostnames', InputArgument::IS_ARRAY,
                'Specify the hostnames you want to request a certificate for [example.com www.example.com ..].')
            ->addOption('http', false, InputOption::VALUE_OPTIONAL,
                'Specify the public directory for this domain, solves the verification using file placement.', false)
            ->addOption('dns', false, InputOption::VALUE_OPTIONAL,
                'Set to true, to solve verification using DNS, will wait for you to set the record.', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('http')) {
            return $this->runHttpMethod($input, $output);
        } elseif ($input->getOption('dns')) {
            // todo
        }
    }

    protected function runHttpMethod(InputInterface $input, OutputInterface $output)
    {
        $public_path = rtrim($input->getOption('http'), '/');
        $challenge_path = "{$public_path}/.well-known/acme-challenge/";

        if (!is_dir($challenge_path)) {
            if( !mkdir($challenge_path, 0755, true)) {
                $output->writeln('<error>Unable to generate the acme challenge directory in the specified public directory, manually create path or set ownership to: ' . $challenge_path);
                return;
            }
        }

        // Set the challenge path.
        Http01Solver::setChallengePublicPath($challenge_path);



    }
}