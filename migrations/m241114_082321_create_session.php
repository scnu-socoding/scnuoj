<?php

use yii\db\Migration;

/**
 * Class m241114_082321_create_session
 */
class m241114_082321_create_session extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('session', [
            'id' => $this->char(40)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
        ]);
        $this->addPrimaryKey('pk_session_id', 'session', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('session');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241114_082321_create_session cannot be reverted.\n";

        return false;
    }
    */
}
