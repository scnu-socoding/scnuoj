<?php

use yii\db\Migration;

/**
 * Class m210114_100353_add_setting_option
 */
class m210114_100353_add_setting_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', ['key' => 'notice', 'value' => '本系统正在试运行中。']); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['key' => 'notice']);
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210114_100353_add_setting_option cannot be reverted.\n";

        return false;
    }
    */
}
