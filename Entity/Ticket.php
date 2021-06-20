<?php

namespace Host2x\Support;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null support_ticket_id
 * @property string ticket_id
 *
 * RELATIONS
 */
class Ticket extends Entity
{

    protected function _preSave()
    {
        if ($this->isInsert()) {
            $this->ticket_id = $this->getTicketRepo()->randomTicketId();
        }
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = "host2x_support_tickets";
        $structure->shortName = 'Host2x\Support:Ticket';
        $structure->primaryKey = 'support_ticket_id';

        $structure->columns = [
            'support_ticket_id' => ['type' => self::UINT, 'nullable' => true, 'autoIncrement' => true],
            'ticket_id' => ['type' => self::STR, 'maxLength' => 25, 'default' => ''],
            'title' => ['type' => self::STR, 'required' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            
        ];
    }

    /**
     * @return \Host2x\Support\Repository\Status|\XF\Mvc\Entity\Repository
     */
    protected function getTicketRepo()
    {
        return $this->repository('Host2x\Support:Ticket');
    }

}