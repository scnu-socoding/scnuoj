<?php

use yii\db\Migration;

/**
 * Class m220103_152840_add_contest_option
 */
class m220103_152840_add_contest_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contest}}', 'enable_board',  $this->smallInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contest}}', 'enable_board');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220103_152840_add_contest_option cannot be reverted.\n";

        return false;
    }
    */
}
