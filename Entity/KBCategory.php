<?php

namespace Host2x\Support\Entity;

use XF\Mvc\Entity\Structure;

use XF\Entity\AbstractCategoryTree;

/**
 * COLUMNS
 * @property int kb_category_id
 * @property string title
 * @property string description
 * @property int article_count
 * @property int parent_category_id
 * @property int display_order
 * @property int lft
 * @property int rgt
 * @property int depth
 * @property array breadcrumb_data
 *
 * GETTERS
 * @property \XF\Draft draft_article
 *
 * RELATIONS
 * @property \XF\Entity\Draft[] DraftArticles
 * @property \XF\Entity\PermissionCacheContent[] Permissions
 */
class KBCategory extends AbstractCategoryTree
{
    protected $_viewableDescendants = [];


    /**
     * @return array
     */
    public function getCategoryListExtras()
    {
        return [
            'article_count' => $this->article_count,
        ];
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'host2x_kb_category';
        $structure->shortName = 'Host2x\Support:KBCategory';
        $structure->primaryKey = 'kb_category_id';
        $structure->contentType = 'host2x_kb_category';

        $structure->columns = [
            'kb_category_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' => ['type' => self::STR,
                'required' => 'please_enter_valid_title', 'maxLength' => 100
            ],
            'description' => ['type' => self::STR, 'default' => ''],
            'article_count' => ['type' => self::UINT, 'forced' => true, 'default' => 0],
        ];

        $structure->getters = [
            'draft_article' => true
        ];

        $structure->relations = [
            'DraftArticles' => [
                'entity' => 'XF:Draft',
                'type' => self::TO_MANY,
                'conditions' => [
                    ['draft_key', '=', 'host2x-kb-category-', '$category_id']
                ],
                'key' => 'user_id'
            ]
        ];

        $structure->options = [
            'delete_articles' => true
        ];

        static::addCategoryTreeStructureElements($structure);

        return $structure;
    }
}