<?php
namespace DSFacyt\InfrastructureBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DSFacyt\Core\Application\UseCases\IntelligentAgent\DeletePublish\DeletePublishCommand;

/**
 * El siguiente commando se encarga de analizar y cambiar los estados de las publicaciones
 *
 * Class  CheckStatusCommnad
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 */
class CleanOldDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ds_facyt:clean-old-data')
            ->setDescription('Elimina las publicaciones viejas en el sistema');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        global $kernel;
        $container = $kernel->getContainer();
        $maxDate = $container->get('ConfigurationDSFacyt')->getConfig()['time_clean_publish'];
        $command = new DeletePublishCommand($maxDate);
        $response = $container->get('CommandBus')->execute($command);
        $output->writeln('-'.(new \DateTime())->format('Y-m-d h:m:s').' '.$response->getMessage());
    }
}
