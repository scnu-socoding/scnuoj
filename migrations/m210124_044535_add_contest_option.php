<?php

use yii\db\Migration;

/**
 * Class m210124_044535_add_contest_option
 */
class m210124_044535_add_contest_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contest}}', 'invite_code', $this->text());
        $this->addColumn('{{%contest}}', 'ext_link', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contest}}', 'invite_code');
        $this->dropColumn('{{%contest}}', 'ext_link');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210124_044535_add_contest_option cannot be reverted.\n";

        return false;
    }
    */
}
