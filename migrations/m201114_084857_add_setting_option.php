<?php

use yii\db\Migration;

/**
 * Class m201114_084857_add_setting_option
 */
class m201114_084857_add_setting_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', ['key' => 'submitTime', 'value' => '0']); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['key' => 'submitTime']); 
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201114_084857_add_setting_option cannot be reverted.\n";

        return false;
    }
    */
}
