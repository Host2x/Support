<?php

namespace Host2x\Support\Repository;

use XF\Mvc\Entity\Finder;
use XF\Repository\AbstractCategoryTree;

class KBCategory extends AbstractCategoryTree
{
    /**
     * @return string
     */
    protected function getClassName()
    {
        return 'Host2x\Support:KBCategory';
    }

    public function mergeCategoryListExtras(array $extras, array $childExtras)
    {
        $output = array_merge([
            'article_count' => 0,
            'childCount' => 0
        ], $extras);

        foreach ($childExtras AS $child)
        {
            if (!empty($child['article_count']))
            {
                $output['article_count'] += $child['article_count'];
            }
            $output['childCount'] += 1 + (!empty($child['childCount']) ? $child['childCount'] : 0);
        }
        return $output;
    }
}