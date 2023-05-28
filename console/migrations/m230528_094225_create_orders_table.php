<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m230528_094225_create_orders_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'client_name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'adress' => $this->string()->notNull(),
            'products' => $this->text(),
            'status' => $this->smallInteger()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
    }
}
