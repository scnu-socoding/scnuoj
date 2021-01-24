<?php

use yii\db\Migration;

/**
 * Class m210124_145608_add_contest_option
 */
class m210124_145608_add_contest_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contest}}', 'enable_print',  $this->smallInteger()->defaultValue(0));
        $this->addColumn('{{%contest}}', 'enable_clarify', $this->smallInteger()->defaultValue(1));
        $this->addColumn('{{%contest_user}}', 'is_out_of_competition', $this->smallInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contest}}', 'enable_print');
        $this->dropColumn('{{%contest}}', 'enable_clarify');
        $this->dropColumn('{{%contest_user}}', 'is_out_of_competition');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210124_145608_add_contest_option cannot be reverted.\n";

        return false;
    }
    */
}
