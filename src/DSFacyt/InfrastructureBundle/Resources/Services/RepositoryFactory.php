<?php

namespace DSFacyt\InfrastructureBundle\Resources\Services;

use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use DSFacyt\InfrastructureBundle\Repositories\DbCancellationPolicyRepository;


/**
 *	Clase RepositoryFactory modela un servicio usado por el commandBus y los handler para obtener
 *	determinados repositorios en el momento que sean requeridos
 *	@author Freddy Contreras <freddycontreras3@gmail.com>
 *	@author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 *	@version 31/08/2015
 */
class RepositoryFactory implements RepositoryFactoryInterface
{
    protected $em;

    protected $map = array(
        'Channel'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbChannelRepository',
            'entity'=>'DSFacytDomain:Channel'
        ),
        'Document'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbDocumentRepository',
            'entity'=>'DSFacytDomain:Document'
        ),
        'Image'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbImageRepository',
            'entity'=>'DSFacytDomain:Image'
        ),
        'QuickNote'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbQuickNoteRepository',
            'entity'=>'DSFacytDomain:QuickNote'
        ),
        'School'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbSchoolRepository',
            'entity'=>'DSFacytDomain:School'
        ),
        'Text'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbTextRepository',
            'entity'=>'DSFacytDomain:Text'
        ),
        'User'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbUserRepository',
            'entity'=>'DSFacytDomain:User'
        ),
        'Video'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbVideoRepository',
            'entity'=>'DSFacytDomain:Video'
        ),
        'Group'=>array(
            'repository'=>'DSFacyt\InfrastructureBundle\Repositories\DbGroupRepository',
            'entity'=>'DSFacytDomain:Group'
        ),
    );

    public function __construct($em = null)
    {
        $this->em = $em;
    }

    /**
     *	Devuelve el objeto repoisitorio de la entidad que se pasa por parametro
     *
     *	@author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     *	@version 19/05/2015
     *	@param String
     *	@return EntityRepository
     */
    public function get($entity)
    {

        if(array_key_exists($entity,$this->map)){
            if(isset($this->map[$entity]['entity']))
            {
                return new $this->map[$entity]['repository']($this->em, new ClassMetadata($this->map[$entity]['entity']));
			}else{
                return new $this->map[$entity]['repository']($this->em);
			}
            return null;
        }

        return null;
    }
}