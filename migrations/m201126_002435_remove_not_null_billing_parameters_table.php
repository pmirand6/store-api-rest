<?php

use yii\db\Migration;

/**
 * Class m201126_002435_remove_not_null_billing_parameters_table
 */
class m201126_002435_remove_not_null_billing_parameters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%billing_parameters}}', 'mercado_pago_rsn', $this->string(128));
        $this->alterColumn('{{%billing_parameters}}', 'mercado_pago_alitaware', $this->string(128));
        $this->alterColumn('{{%billing_parameters}}', 'commission_percent', $this->double());
        $this->alterColumn('{{%billing_parameters}}', 'iva_percent', $this->double());
        $this->alterColumn('{{%billing_parameters}}', 'commission_percent_rsn', $this->double());
        $this->alterColumn('{{%billing_parameters}}', 'commission_percent_alitaware', $this->double());
        $this->alterColumn('{{%billing_parameters}}', 'cost_until_20kg', $this->double());
        $this->alterColumn('{{%billing_parameters}}', 'cost_higher_20kg', $this->double());
        $this->alterColumn('{{%billing_parameters}}', 'cost_per_km_until_20kg', $this->double());
        $this->alterColumn('{{%billing_parameters}}', 'cost_per_km_higher_20kg', $this->double());
        $this->alterColumn('{{%billing_parameters}}', 'url_api_rsn', $this->string(255));
        $this->alterColumn('{{%billing_parameters}}', 'url_api_alitaware', $this->string(255));
        $this->alterColumn('{{%billing_parameters}}', 'user', $this->string(255));
        $this->alterColumn('{{%billing_parameters}}', 'password', $this->string(255));
        $this->alterColumn('{{%billing_parameters}}', 'client_id', $this->string(255));
        $this->alterColumn('{{%billing_parameters}}', 'secret_key', $this->string(255));
        $this->alterColumn('{{%billing_parameters}}', 'company', $this->string(128));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201126_002435_remove_not_null_billing_parameters_table cannot be reverted.\n";

        $this->alterColumn('{{%billing_parameters}}', 'mercado_pago_rsn', $this->string(128)->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'mercado_pago_alitaware', $this->string(128)->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'commission_percent', $this->double()->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'iva_percent', $this->double()->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'commission_percent_rsn', $this->double()->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'commission_percent_alitaware', $this->double()->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'cost_until_20kg', $this->double()->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'cost_higher_20kg', $this->double()->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'cost_per_km_until_20kg', $this->double()->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'cost_per_km_higher_20kg', $this->double()->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'url_api_rsn', $this->string(255)->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'url_api_alitaware', $this->string(255)->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'user', $this->string(255)->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'password', $this->string(255)->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'client_id', $this->string(255)->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'secret_key', $this->string(255)->notNull());
        $this->alterColumn('{{%billing_parameters}}', 'company', $this->string(128)->notNull());

        return true;
    }

}
