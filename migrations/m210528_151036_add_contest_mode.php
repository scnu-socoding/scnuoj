<?php

use yii\db\Migration;

/**
 * Class m210528_151036_add_contest_mode
 */
class m210528_151036_add_contest_mode extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', ['key' => 'isContestMode', 'value' => '0']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['key' => 'isContestMode']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210528_151036_add_contest_mode cannot be reverted.\n";

        return false;
    }
    */
}
