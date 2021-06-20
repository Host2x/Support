<?php

namespace Host2x\Support\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null status_id
 * @property int display_order
 * @property bool active
 *
 * GETTERS
 * @property \XF\Phrase title
 *
 * RELATIONS
 * @property \XF\Entity\Phrase MasterTitle
 */
class Status extends Entity
{
    /**
     * @return \XF\Phrase
     */
    public function getTitle()
    {
        return \XF::phrase($this->getPhraseName());
    }

    public function getPhraseName()
    {
        return 'host2x_support_status.' . $this->status_id;
    }

    public function getMasterPhrase()
    {
        $phrase = $this->MasterTitle;

        if (!$phrase)
        {
            /** @var \XF\Entity\Phrase $phrase */
            $phrase = $this->_em->create('XF:Phrase');
            $phrase->title = $this->_getDeferredValue(function() {
                return $this->getPhraseName();
            }, 'save');
            $phrase->language_id = 0;
            $phrase->addon_id = '';
        }

        return $phrase;
    }

    protected function _postDelete()
    {
        if ($this->MasterTitle) {
            $this->MasterTitle->delete();
        }

        // TODO: delete tickets with this condition?
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'host2x_support_statuses';
        $structure->shortName = 'Host2x\Support:Status';
        $structure->primaryKey = 'status_id';

        $structure->columns = [
            'status_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'display_order' => ['type' => self::UINT, 'default' => 0],
            'active' => ['type' => self::BOOL, 'default' => true],
        ];

        $structure->getters = [
            'title' => true,
        ];

        $structure->relations = [
            'MasterTitle' => [
                'entity' => 'XF:Phrase',
                'type' => self::TO_ONE,
                'conditions' => [
                    ['language_id', '=', 0],
                    ['title', '=', 'host2x_support_status.', '$status_id']
                ]
            ]
        ];

        return $structure;
    }

    /**
     * @return \Host2x\Support\Repository\Status|\XF\Mvc\Entity\Repository
     */
    protected function getStatusRepo()
    {
        return $this->repository('Host2x\Support:Status');
    }
}