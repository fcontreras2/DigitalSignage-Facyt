<?php 

namespace DSFacyt\Core\Application\Services;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;


/**
 *
 * CommandBus se encarga de recibir los comandos que provienen de 
 * 
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31/08/2015
 * 
 */
class CommandBus
{
    private $rf;

     /**
     * Create a new CommandBus
     *
     * @param Container $container
     * @return void
     */
    public function __construct($rf)
    { 
        $this->rf=$rf;
    }
 
    /**
     * Execute a Command by passing it to a Handler
     *
     * @param Command $command
     * @return void
     */
    public function execute(Command $command)
    {
        $handler = $this->handler($command);
        if($handler!=null)
        {
            return $handler->handle($command,$this->rf);
        }else{
            return new ResponseCommandBus(404,'Handler not Found');
        }
    }
 
    /**
     * Get the Command Handler
     *
     * @return mixed
     */
    private function handler(Command $command)
    {
        $class = $this->inflect($command);
        if(\class_exists($class)){
            return new $class();
        }else{
            return null;
        }
    }

    /**
     * Encuentra un Manejador para un comando reemplazando 'Command' por 'Handler'
     *
     * @param Command $command
     * @return string
     */
    private function inflect(Command $command)
    {
        $commandclass = \get_class($command);
        $handlerclass =str_replace('Command', 'Handler', $commandclass);
        return $handlerclass;
    }
}