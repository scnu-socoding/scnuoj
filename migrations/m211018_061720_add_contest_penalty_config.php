<?php

use yii\db\Migration;

/**
 * Class m211018_061720_add_contest_penalty_config
 */
class m211018_061720_add_contest_penalty_config extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contest}}', 'punish_time',  $this->smallInteger()->defaultValue(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contest}}', 'punish_time');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211018_061720_add_contest_penalty_config cannot be reverted.\n";

        return false;
    }
    */
}
