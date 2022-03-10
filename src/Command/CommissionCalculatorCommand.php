<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Exception;

#[AsCommand(
    name: 'CommissionCalculator',
    description: 'Calculate the commision per transaction',
)]
class CommissionCalculatorCommand extends Command
{
    protected function configure(): void
    {
        $this
            // ->addArgument('input_file_path', InputArgument::OPTIONAL, 'JSON Formatted')
            ->addOption('input_file_path', null, InputOption::VALUE_REQUIRED, 'List of transactions - JSON Formatted')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // $inputFileName = $input->getArgument('input_file_path');
        $inputFilePath = $input->getOption('input_file_path');

        try{

            if (!file_exists($inputFilePath)) {
                throw new Exception\InputFileNotExists();
            }

            // TODO code here

            $io->success('Calculation has been finished successfully');
        

        } catch (\Throwable $e) {
            $io->error('Something Went Wrong..!');
            $io->note($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
