<?php

use yii\db\Migration;

/**
 * Class m201111_025150_add_setting_option
 */
class m201111_025150_add_setting_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', ['key' => 'isDefGroup', 'value' => '3']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['key' => 'isDefGroup']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201111_025150_add_setting_option cannot be reverted.\n";

        return false;
    }
    */
}
