<?php

namespace Host2x\Support\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class Status extends AbstractController
{

    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertAdminPermission('tickets');
    }

    public function actionIndex()
    {
        $statusRepo = $this->getStatusRepo();
        $statuses = $statusRepo->findStatusesForList()->fetch();

        $viewParams = [
            'statuses' => $statuses
        ];

        return $this->view('Host2x\Support:Status\List', 'host2x_support_status_list', $viewParams);
    }

    public function statusAddEdit(\Host2x\Support\Entity\Status $status)
    {
        $viewParams = [
            'status' => $status
        ];
        return $this->view('Host2x\Support:Status\Edit', 'host2x_support_status_edit', $viewParams);
    }

    public function actionEdit(ParameterBag $params)
    {
        $condition = $this->assertStatusExists($params->status_id);
        return $this->statusAddEdit($condition);
    }

    public function actionAdd()
    {
        $status = $this->em()->create('Host2x\Support:Status');
        return $this->statusAddEdit($status);
    }

    protected function statusSaveProcess(\Host2x\Support\Entity\Status $status)
    {
        $entityInput = $this->filter([
            'display_order' => 'uint'
        ]);

        $form = $this->formAction();
        $form->basicEntitySave($status, $entityInput);

        $titlePhrase = $this->filter('title', 'str');

        $form->validate(function(FormAction $form) use ($titlePhrase)
        {
            if ($titlePhrase === '')
            {
                $form->logError(\XF::phrase('please_enter_valid_title'), 'title');
            }
        });

        $form->apply(function() use ($titlePhrase, $status)
        {
            $masterTitle = $status->getMasterPhrase();
            $masterTitle->phrase_text = $titlePhrase;
            $masterTitle->save();
        });

        return $form;
    }

    public function actionSave(ParameterBag $params)
    {
        $this->assertPostOnly();

        if ($params->status_id)
        {
            $condition = $this->assertStatusExists($params->status_id);
        }
        else
        {
            $condition = $this->em()->create('Host2x\Support:Status');
        }

        $this->statusSaveProcess($condition)->run();

        return $this->redirect($this->buildLink('support/statuses'));
    }

    public function actionDelete(ParameterBag $params)
    {
        return $this->noPermission();

        $status = $this->assertStatusExists($params->status_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $status,
            $this->buildLink('support/statuses/delete', $status),
            $this->buildLink('support/statuses/edit', $status),
            $this->buildLink('support/statuses'),
            $this->app->stringFormatter()->snippetString($status->title, 150)
        );
    }

    public function actionToggle()
    {
        return $this->noPermission();

        /** @var \XF\ControllerPlugin\Toggle $plugin */
        $plugin = $this->plugin('XF:Toggle');
        return $plugin->actionToggle('Host2x\Support:Status');
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \Host2x\Support\Entity\Status
     */
    protected function assertStatusExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('Host2x\Support:Status', $id, $with, $phraseKey);
    }

    /**
     * @return \Host2x\Support\Repository\Status
     */
    protected function getStatusRepo()
    {
        return $this->repository('Host2x\Support:Status');
    }
}