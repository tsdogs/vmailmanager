<?php

use yii\db\Migration;

/**
 * Class m230421_075627_add_password_rules
 */
class m230421_075627_add_password_rules extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%account}}','password_renewtime',$this->integer()->null());
        $this->addColumn('{{%account}}','password_expireson',$this->integer()->null());
        $this->addColumn('{{%account}}','password_expired',$this->boolean()->defaultValue(false)->notNull());
        $this->addColumn('{{%account}}','last_login',$this->integer()->null());
        $this->addColumn('{{%account}}','last_login_ip',$this->string(50)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%account}}','password_renewtime');
        $this->dropColumn('{{%account}}','password_expireson');
        $this->dropColumn('{{%account}}','password_expired');
        $this->dropColumn('{{%account}}','last_login');
        $this->dropColumn('{{%account}}','last_login_ip');
        
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230421_075627_add_password_rules cannot be reverted.\n";

        return false;
    }
    */
}
