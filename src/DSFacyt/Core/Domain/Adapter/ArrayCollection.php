<?php

namespace DSFacyt\Core\Domain\Adapter;

use Doctrine\Common\Collections\ArrayCollection as DoctrineArrayCollection;
use DSFacyt\Core\Domain\Contract\Collection;

/**
* La clase siguiente extiende los métodos del ArrayCollection
* de Doctrine y implementa los métodos del Collection de Doctrine
*
* @author Fredddy Contreras <freddycontreras3@gmail.com>
*/
class ArrayCollection extends DoctrineArrayCollection implements Collection {}