<?php

use yii\db\Migration;

class m191118_144443_01_create_table_domain extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%domain}}', [
            'id' => $this->primaryKey(),
            'domain' => $this->string(250)->notNull(),
            'destination' => $this->string(250)->notNull(),
            'description' => $this->string(250),
            'aliases' => $this->integer()->defaultValue('0'),
            'mailboxes' => $this->integer()->defaultValue('0'),
            'quota' => $this->integer()->defaultValue('0'),
            'active' => $this->tinyInteger(1)->defaultValue('1'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('domain_idx1', '{{%domain}}', 'domain', true);
    }

    public function down()
    {
        $this->dropTable('{{%domain}}');
    }
}
