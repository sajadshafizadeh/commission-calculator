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
use App\Service;

#[AsCommand(
    name: 'CommissionCalculator',
    description: 'Calculate the commision per transaction',
)]
class CommissionCalculatorCommand extends Command
{

    // private const EXCHANGE_RATES_FILE = "http://api.exchangeratesapi.io/latest?access_key=83e75e5b7793d79b4b7087dfab274276";
    private const EXCHANGE_RATES_FILE = "rates.json"; // used for tests, because the API has a limitation reach (500 call per month)

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

        try {

            // To get list of all exchanges
            $exchangeRatesObject = new Service\Exchange(self::EXCHANGE_RATES_FILE);
            $exchangeRates = $exchangeRatesObject->getRates();

            // To load the input file
            $inputHandlerObject = new Service\InputHandler($inputFilePath);
            $entries = $inputHandlerObject->inputLoader();

            // To canculate the commision
            $commisionObject = new Service\Commission($exchangeRates);

            // To loop on the transactions
            foreach ($entries as $entry)  {

                $transactionObject = $inputHandlerObject->transactionParser($entry);
                $commission = $commisionObject->calculateCommission($transactionObject);
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
