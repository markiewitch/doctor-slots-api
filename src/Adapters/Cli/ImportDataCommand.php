<?php
declare(strict_types=1);

namespace App\Adapters\Cli;

use App\Action\SynchronizeAllDoctors;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class ImportDataCommand extends Command
{
    public function __construct(private MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:import:all');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bus->dispatch(new SynchronizeAllDoctors());

        return Command::SUCCESS;
    }
}
