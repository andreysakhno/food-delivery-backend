<?php

use yii\db\Migration;

/**
 * Class m230526_061136_foods
 */
class m230526_061136_foods extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%foods}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'price' => $this->float()->notNull(),
            'photo' => $this->string(),
            'status' => $this->smallInteger()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-foods-shop_id}}', '{{%foods}}', 'shop_id');

        $this->addForeignKey('{{%fk-foods-shop_id}}', '{{%foods}}', 'shop_id', '{{%shops}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%foods}}');
    }
}
