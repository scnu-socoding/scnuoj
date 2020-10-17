<?php

use yii\db\Migration;

/**
 * Class m201111_023715_add_setting_option
 */
class m201111_023715_add_setting_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', ['key' => 'isUserReg', 'value' => '1']);
        $this->insert('{{%setting}}', ['key' => 'isDiscuss', 'value' => '1']);
        $this->insert('{{%setting}}', ['key' => 'isChangeNickName', 'value' => '2']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['key' => 'isUserReg']);
        $this->delete('{{%setting}}', ['key' => 'isDiscuss']);
        $this->delete('{{%setting}}', ['key' => 'isChangeNickName']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201111_023715_add_setting_option cannot be reverted.\n";

        return false;
    }
    */
}