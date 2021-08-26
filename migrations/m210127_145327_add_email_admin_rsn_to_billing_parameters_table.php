<?php

use yii\db\Migration;

/**
 * Class m210127_145327_add_email_admin_rsn_to_billing_parameters_table
 */
class m210127_145327_add_email_admin_rsn_to_billing_parameters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%billing_parameters}}', 'email_admin_rsn', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210127_145327_add_email_admin_rsn_to_billing_parameters_table cannot be reverted.\n";

        $this->dropColumn('{{%billing_parameters}}', 'email_admin_rsn');

        return true;
    }
}
