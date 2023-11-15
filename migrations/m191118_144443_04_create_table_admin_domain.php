<?php

use yii\db\Migration;

class m191118_144443_04_create_table_admin_domain extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin_domain}}', [
            'id' => $this->primaryKey(),
            'admin_id' => $this->integer()->notNull(),
            'domain' => $this->string(250)->notNull(),
            'active' => $this->tinyInteger(1)->defaultValue('1'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('admin_domain_idx1', '{{%admin_domain}}', ['id', 'domain'], true);
        $this->addForeignKey('admin_domain_fk1', '{{%admin_domain}}', 'admin_id', '{{%admin}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('admin_domain_fk2', '{{%admin_domain}}', 'domain', '{{%domain}}', 'domain', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%admin_domain}}');
    }
}
