<?php

use yii\db\Migration;

class m191118_144443_03_create_table_admin extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin}}', [
            'id' => $this->integer()->notNull(),
            'master' => $this->tinyInteger(1)->defaultValue('0'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('admin_idx1', '{{%admin}}', 'id', true);
        $this->addForeignKey('admin_fk1', '{{%admin}}', 'id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%admin}}');
    }
}
