<?php

use yii\db\Migration;

/**
 * Class m201114_083347_add_setting_option
 */
class m201114_083347_add_setting_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', ['key' => 'ojEditor', 'value' => 'app\widgets\kindeditor\KindEditor']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['key' => 'ojEditor']);   
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201114_083347_add_setting_option cannot be reverted.\n";

        return false;
    }
    */
}
