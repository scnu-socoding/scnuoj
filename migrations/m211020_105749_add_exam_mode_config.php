<?php

use yii\db\Migration;

/**
 * Class m211020_105749_add_exam_mode_config
 */
class m211020_105749_add_exam_mode_config extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', ['key' => 'examContestId', 'value' => '0']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}', ['key' => 'examContestId']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211020_105749_add_exam_mode_config cannot be reverted.\n";

        return false;
    }
    */
}
