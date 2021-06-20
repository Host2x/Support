<?php

namespace Host2x\Support\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Status extends Repository
{
    /**
     * @return Finder
     */
    public function findStatusesForList()
    {
        return $this->finder('Host2x\Support:Status')
            ->setDefaultOrder('display_order');
    }
}