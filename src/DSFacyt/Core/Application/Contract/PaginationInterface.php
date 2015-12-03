<?php
namespace DSFacyt\Core\Application\Contract;

/**
 * Interface de la paginación de los datos
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 26/11/2015
 */
interface PaginationInterface
{
	/**
    * La siguiente función aplica la paginación de un conjunto de datos
    * 
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @version 02/12/2015
    * @return array 
    */
    public function generate(&$data, $numberPage);    
}