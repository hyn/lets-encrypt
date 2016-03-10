<?php

namespace Hyn\LetsEncrypt\Commands;

use Hyn\LetsEncrypt\Helpers\Configured;
use Hyn\LetsEncrypt\Resources\Account;
use Hyn\LetsEncrypt\Resources\Certificate;
use Hyn\LetsEncrypt\Solvers\Http01Solver;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CertificateRequestCommand extends Command
{
    use Configured;
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('certificate:request')
            ->addArgument('hostnames', InputArgument::IS_ARRAY,
                'Specify the hostnames you want to request a certificate for [example.com www.example.com ..].')
            ->addOption('account', 'a', InputOption::VALUE_REQUIRED,
                'Lets Encrypt account name, does not have to exist.')
            ->addOption('email', 'e', InputOption::VALUE_REQUIRED,
                'Lets Encrypt email address.')
            ->addOption('http', false, InputOption::VALUE_OPTIONAL,
                'Specify the public directory for this domain, solves the verification using file placement.', false)
            ->addOption('target', 't', InputOption::VALUE_OPTIONAL,
                'Specify the directory to save the resulting certificate into.', getcwd())
//            ->addOption('dns', false, InputOption::VALUE_OPTIONAL,
//                'Set to true, to solve verification using DNS, will wait for you to set the record.', false)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!count($input->getArgument('hostnames'))) {
            $output->writeln('<error>You need to specify valid hostnames!</error>');
            return;
        }

        $certificate = null;

        if ($input->getOption('http')) {
            $certificate = $this->runHttpMethod($input, $output);
        } elseif ($input->getOption('dns')) {
            // todo
        }

        if ($certificate) {
            return $this->saveResult($certificate);
        }
    }

    /**
     * @param Certificate     $certificate
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function saveResult(Certificate $certificate, InputInterface $input, OutputInterface $output)
    {
        $target_path = rtrim($input->getOption('target'), '/');
        $file_base_name = $input->getArgument('hostnames')[0];

        $pemSize = file_put_contents("$target_path/$file_base_name.pem", $certificate->getCertificate() ."\r\n". $certificate->getBundle());
        $keySize = file_put_contents("$target_path/$file_base_name.key", $certificate->getKey());

        if($pemSize > 0 && $keySize > 0) {
            $output->writeln('<info>Certificate key and pem files written to '.$target_path.'/'.$file_base_name.'.pem/key');
        }
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return Certificate
     * @throws \Exception
     */
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

        $account = new Account($input->getOption('account'), $input->getOption('email'));
        $certificate = new Certificate($account);
        foreach($input->getArgument('hostnames') as $hostname) {
            $certificate->addHostname($hostname);
        }
        $result = $certificate->request();

        $certificate->setCertificate(Arr::get($result, 0));
        $certificate->setBundle(Arr::get($result, 1));

        return $certificate;
    }
}