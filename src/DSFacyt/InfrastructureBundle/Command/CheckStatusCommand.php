<?php
namespace DSFacyt\InfrastructureBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DSFacyt\Core\Application\UseCases\IntelligentAgent\CheckPublish\CheckPublishCommand;

/**
 * El siguiente commando se encarga de analizar y cambiar los estados de las publicaciones
 *
 * Class  CheckStatusCommnad
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 */
class CheckStatusCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ds_facyt:check-status')
            ->setDescription('Analiza y modifica los estados de las publicaciones');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        global $kernel;
        $container = $kernel->getContainer();
        
        $command = new CheckPublishCommand();
        $response = $container->get('CommandBus')->execute($command);
        $output->writeln($response->getMessage());
    }
}
