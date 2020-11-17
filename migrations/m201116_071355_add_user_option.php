<?php

use yii\db\Migration;

/**
 * Class m201116_071355_add_user_option
 */
class m201116_071355_add_user_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_profile}}', 'personal_intro', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_profile}}', 'personal_intro');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201116_071355_add_user_option cannot be reverted.\n";

        return false;
    }
    */
}
