<?php

namespace Host2x\Support\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class KBCategory extends AbstractController
{

    /**
     * @return \XF\ControllerPlugin\AbstractPlugin|\Host2x\Support\ControllerPlugin\KBCategoryTree
     */
    protected function getCategoryTreePlugin()
    {
        return $this->plugin('Host2x\Support:KBCategoryTree');
    }

    /**
     * @return \XF\Mvc\Reply\View
     */
    public function actionIndex()
    {
        return $this->getCategoryTreePlugin()->actionList();
    }

    /**
     * @param      $id
     * @param null $with
     * @param null $phraseKey
     *
     * @return \XF\Mvc\Entity\Entity|\Host2x\Support\Entity\KBCategory
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertKBCategoryExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('Host2x\Support:KBCategory', $id, $with, $phraseKey);
    }

    /**
     * @return \XF\Mvc\Entity\Repository|\Host2x\Support\Repository\KBCategory
     */
    protected function getKBCategoryRepo()
    {
        return $this->repository('Host2x\Support:KBCategory');
    }
}