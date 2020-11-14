<?php

use yii\db\Migration;

/**
 * Class m201114_090421_add_setting_option
 */
class m201114_090421_add_setting_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('{{%setting}}', ['key' => 'ojEditor']);  
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->insert('{{%setting}}', ['key' => 'ojEditor', 'value' => 'app\widgets\kindeditor\KindEditor']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201114_090421_add_setting_option cannot be reverted.\n";

        return false;
    }
    */
}
