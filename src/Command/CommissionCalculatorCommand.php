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
use App\Model\Service;
use App\Model\Entity;

#[AsCommand(
    name: 'CommissionCalculator',
    description: 'Calculate the commision per transaction',
)]
class CommissionCalculatorCommand extends Command
{

    protected function configure(): void
    {
        $this
        ->addOption('input_file_path', null, InputOption::VALUE_REQUIRED, 'List of transactions - JSON Formatted');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /* To get the passed input file path as an option
         * Cast it to string if it's not passed to avoid type-hint-error
         */
        $inputFilePath = (string) $input->getOption('input_file_path');

        try{

            // To get list of all exchanges
            $exchangeRatesObject = new Entity\Exchange;
            $exchangeRates = $exchangeRatesObject->getExchangeRates();

            // To load the input file
            $inputHandlerObject = new Service\InputHandler($inputFilePath);
            $inputContent = $inputHandlerObject->inputLoader();

            // To loop on the transactions
            foreach (explode("\n", $inputContent) as $row)  {

                $transactionObject = $inputHandlerObject->transactionParser($row);
                $commisionObject = new Service\Commission($transactionObject, $exchangeRates);

                $commission = $commisionObject->calculateCommission();
                $io->writeln($commission);
            }

            $io->success('Calculation has been finished successfully');
        

        } catch (\Throwable $e) {
            $io->error('Something Went Wrong..!');
            $io->note($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
