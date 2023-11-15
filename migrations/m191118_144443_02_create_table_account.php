<?php

use yii\db\Migration;

class m191118_144443_02_create_table_account extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull(),
            'domain' => $this->string(250)->notNull(),
            'password' => $this->string()->notNull(),
            'name' => $this->string(200),
            'quota' => $this->integer()->defaultValue('0'),
            'send' => $this->tinyInteger(1)->defaultValue('1'),
            'receive' => $this->tinyInteger(1)->defaultValue('1'),
            'calendar' => $this->tinyInteger(1)->defaultValue('0'),
            'active' => $this->tinyInteger(1)->defaultValue('1'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('account_idx1', '{{%account}}', ['username', 'domain'], true);
        $this->addForeignKey('account_fk1', '{{%account}}', 'domain', '{{%domain}}', 'domain', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%account}}');
    }
}
