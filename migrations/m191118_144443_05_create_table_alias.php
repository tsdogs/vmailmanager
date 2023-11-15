<?php

use yii\db\Migration;

class m191118_144443_05_create_table_alias extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%alias}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100),
            'domain' => $this->string(250)->notNull(),
            'destination' => $this->string(),
            'active' => $this->tinyInteger(1)->defaultValue('1'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('alias_idx1', '{{%alias}}', ['username', 'domain', 'destination'], true);
        $this->addForeignKey('alias_fk1', '{{%alias}}', 'domain', '{{%domain}}', 'domain', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%alias}}');
    }
}
