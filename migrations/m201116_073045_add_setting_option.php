<?php

use yii\db\Migration;

/**
 * Class m201116_073045_add_setting_option
 */
class m201116_073045_add_setting_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', ['key' => 'isUserReg', 'value' => '1']);
        $this->insert('{{%setting}}', ['key' => 'isDiscuss', 'value' => '1']);
        $this->insert('{{%setting}}', ['key' => 'isChangeNickName', 'value' => '2']);
        $this->insert('{{%setting}}', ['key' => 'isDefGroup', 'value' => '3']);
        $this->insert('{{%setting}}', ['key' => 'isGroupJoin', 'value' => '0']);
        $this->insert('{{%setting}}', ['key' => 'isGroupReset', 'value' => '0']);  
        $this->insert('{{%setting}}', ['key' => 'submitTime', 'value' => '0']); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['key' => 'isUserReg']);
        $this->delete('{{%setting}}', ['key' => 'isDiscuss']);
        $this->delete('{{%setting}}', ['key' => 'isChangeNickName']);
        $this->delete('{{%setting}}', ['key' => 'isDefGroup']);
        $this->delete('{{%setting}}', ['key' => 'isGroupJoin']);
        $this->delete('{{%setting}}', ['key' => 'isGroupReset']); 
        $this->delete('{{%setting}}', ['key' => 'submitTime']); 
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201116_073045_add_setting_option cannot be reverted.\n";

        return false;
    }
    */
}
