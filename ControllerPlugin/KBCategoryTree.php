<?php

namespace Host2x\Support\ControllerPlugin;

use XF\ControllerPlugin\AbstractCategoryTree;

class KBCategoryTree extends AbstractCategoryTree
{
    /**
     * @var string
     */
    protected $viewFormatter = 'Host2x\Support:KB\Category\%s';

    /**
     * @var string
     */
    protected $templateFormatter = 'host2x_kb_category_%s';

    /**
     * @var string
     */
    protected $routePrefix = 'support/kb/categories';

    /**
     * @var string
     */
    protected $entityIdentifier = 'Host2x\Support:KBCategory';

    /**
     * @var string
     */
    protected $primaryKey = 'kb_category_id';
}
