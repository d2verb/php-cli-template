<?php

namespace Rich\Console;

use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CatCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('cat')
            ->setDescription('Concatenate and print files')
            ->addArgument('filenames', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Filenames you want to concatenate.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filenames = $input->getArgument('filenames');
        foreach ($filenames as $filename) {
            $this->printFileContent($output, $filename);
        }
        return 0;
    }

    protected function printFileContent(OutputInterface $output, string $filename)
    {
        $handle = fopen($filename, 'r');
        if (!$handle) {
            throw new RuntimeException("Can not open the file: '$filename'");
        }

        while (($buffer = fgets($handle, 4096)) !== false) {
            $output->write($buffer);
        }
        fclose($handle);
    }
}