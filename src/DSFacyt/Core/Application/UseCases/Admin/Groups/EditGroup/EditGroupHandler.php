<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Groups\EditGroup;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;


/**
 * Clase del caso de uso 'Obtener los grupos de usuarios del sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class EditGroupHandler implements Handler
{
    /**
     * Handler del caso de uso 'Editar Grupo de usuarios'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        
        $request = $command->getRequest();
        $group = $rf->get('Group')->findOneBy(['id' => $request['groupId']]);

        $currentPermissons = $group->getDefaultsPermisions();
        $newPermissons = $request['permissons'];

        if ($newPermissons['text'] and !in_array('text',$currentPermissons))
            $currentPermissons[] = 'text';
        else if (!$newPermissons['text'] and in_array('text', $currentPermissons))
            array_splice($currentPermissons,array_search('text', $currentPermissons),1);

        if ($newPermissons['image'] and !in_array('image',$currentPermissons))
            $currentPermissons[] = 'image';
        else if (!$newPermissons['image'] and in_array('image', $currentPermissons))
            array_splice($currentPermissons,array_search('image', $currentPermissons),1);

        if ($newPermissons['video'] and !in_array('video',$currentPermissons))
            $currentPermissons[] = 'video';
        else if (!$newPermissons['video'] and in_array('video', $currentPermissons))
            array_splice($currentPermissons,array_search('video', $currentPermissons),1);

        $group->setDefaultsPermisions($currentPermissons);
        $rf->get('Group')->save($group);

        $rpUser = $rf->get('User');
        foreach ($group->getUsers() as $currentUser) {
            $currentUser->setAccess($currentPermissons);
            $rpUser->save($currentUser);
        }

        return new ResponseCommandBus(200, 'Ok');
    }
}