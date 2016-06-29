<?php
<?php

namespace DSFacyt\Core\Application\UseCases\Display\CheckPublish;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Verifica los cambios que surgieron en un canal que se encuentra transmición'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */
class GetCheckPublishCommand implements Command
{
    /**
     * @var string representa el slug del canal
     */
    private $slug;

    public function __construct($slug = null)
    {
        $this->slug =  $slug;
    }

    public function getRequest()
    {
        return ['slug' => $this->slug];
    }
}
