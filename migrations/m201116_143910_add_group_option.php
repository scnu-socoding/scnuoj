<?php

use yii\db\Migration;

/**
 * Class m201116_143910_add_group_option
 */
class m201116_143910_add_group_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%group}}', 'kanban', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%group}}', 'kanban');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201116_143910_add_group_option cannot be reverted.\n";

        return false;
    }
    */
}
