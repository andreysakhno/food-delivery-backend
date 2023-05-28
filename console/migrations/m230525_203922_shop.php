<?php

use yii\db\Migration;

/**
 * Class m230525_203922_shop
 */
class m230525_203922_shop extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shops}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'coords' => $this->string(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%shops}}');
    }
}
