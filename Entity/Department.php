<?php

namespace Host2x\Support\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 *
 * RELATIONS
 */
class Department extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = "host2x_support_departments";
        $structure->shortName = 'Host2x\Support:Department';
        $structure->primaryKey = 'department_id';

        $structure->columns = [
            'department_id' => ['type' => self::UINT, 'nullable' => true, 'autoIncrement' => true],
            'name' => ['type' => self::STR, 'required' => true, 'maxLength' => 50],
            'description' => ['type' => self::STR, 'default' => ''],
            'hidden' => ['type' => self::BOOL, 'default' => 0],
            'ticket_count' => ['type' => self::UINT, 'forced' => true, 'default' => 0],
            'display_order' => ['type' => self::UINT, 'default' => 0]
        ];

        return $structure;
    }
}