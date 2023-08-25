<?php

namespace Host2x\Support;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;


    /**
     * Create support tables
     */
    public function installStep1()
    {
        $schemaManager = $this->schemaManager();

        // create the tables that we need
        $schemaManager->createTable('host2x_support_tickets', function (Create $table) {
            $table->checkExists(true);
            $table->addColumn('ticket_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 255)->nullable(false);
            $table->addColumn('user_id', 'int')->unsigned(true)->nullable(false);
            $table->addColumn('department_id', 'int')->unsigned(true)->nullable(false);
            $table->addColumn('status_id', 'int')->unsigned(true)->nullable(false);
            $table->addColumn('assigned_user_id', 'int')->unsigned(true)->nullable(false);
            $table->addColumn('thread_id', 'int')->unsigned(true)->nullable(false);

            $table->addPrimaryKey('ticket_id');
        });

        $schemaManager->createTable('host2x_support_statuses', function (Create $table) {
            $table->checkExists(true);
            $table->addColumn('status_id', 'int')->autoIncrement();
            $table->addColumn('display_order', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addColumn('active', 'int')->unsigned(true)->nullable(false)->setDefault(1);

            $table->addPrimaryKey('status_id');
        });

        $schemaManager->createTable('host2x_support_departments', function (Create $table) {
            $table->checkExists(true);
            $table->addColumn('department_id', 'int')->autoIncrement();
            $table->addColumn('name', 'varchar', 50)->nullable(false);
            $table->addColumn('description','mediumtext')->nullable(false);
            $table->addColumn('hidden', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addColumn('ticket_count', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addColumn('display_order', 'int')->unsigned(true)->nullable(false)->setDefault(0);

            $table->addPrimaryKey('department_id');
        });

        $schemaManager->createTable('host2x_kb_category', function (Create $table){
            $table->checkExists(true);
            $table->addColumn('kb_category_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 100)->nullable(false);
            $table->addColumn('description', 'mediumtext')->nullable(false);
            $table->addColumn('article_count', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addColumn('parent_category_id', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addColumn('display_order', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addColumn('lft', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addColumn('rgt', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addColumn('depth', 'int')->unsigned(true)->nullable(false)->setDefault(0);
            $table->addPrimaryKey('kb_category_id');
        });
    }

    /**
     * Drop support tables
     */
    public function uninstallStep1()
    {
        $schemaManager = $this->schemaManager();

        // drop our tables
        $schemaManager->dropTable('host2x_support_tickets');
        $schemaManager->dropTable('host2x_support_statuses');
        $schemaManager->dropTable('host2x_support_departments');
        $schemaManager->dropTable('host2x_kb_category');
    }
}