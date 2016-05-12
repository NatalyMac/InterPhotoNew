<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Resizer\Resizer;
/**
* ResizePhotoCommand
*/
class ResizePhotoCommand extends Command
{
    /**
     * Configuration of command
     */
    protected function configure()
    {
        $this
            ->setName("resize:photo")
            ->setDescription("Command resize:photo")
            ->addArgument(
                'jsonFile',
                InputArgument::REQUIRED,
                'Json file with configurations'
            );

    }

    /**
     * Execute method of command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */


    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(array("","<info>Execute</info>",""));
        $jsonFile = $input->getArgument('jsonFile');

        if (!file_exists($jsonFile)) {
            $output->writeln('Error: Json file does not exists');

            return true;
        }

        $jsonFileContent = file_get_contents($jsonFile);

        $config = json_decode($jsonFileContent, true);
        
        if (!is_array($config)) {
            $output->writeln('Error: Json file does not seams valid');

            return true;
        }

        $resizer = new Resizer($config);
        $resizer ->resizeImages();
    }
}