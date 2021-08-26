<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%billing_parameters}}`.
 */
class m201105_030236_create_billing_parameters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%billing_parameters}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'mercado_pago_rsn' => $this->string(128)->notNull(),
            'mercado_pago_alitaware' => $this->string(128)->notNull(),
            'commission_percent' => $this->double()->notNull(),
            'iva_percent' => $this->double()->notNull(),
            'commission_percent_rsn' => $this->double()->notNull(),
            'commission_percent_alitaware' => $this->double()->notNull(),
            'cost_until_20kg' => $this->double()->notNull(),
            'cost_higher_20kg' => $this->double()->notNull(),
            'cost_per_km_until_20kg' => $this->double()->notNull(),
            'cost_per_km_higher_20kg' => $this->double()->notNull(),
            'url_api_rsn' => $this->string(255)->notNull(),
            'url_api_alitaware' => $this->string(255)->notNull(),
            'user' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'client_id' => $this->string(255)->notNull(),
            'secret_key' => $this->string(255)->notNull(),
            'company' => $this->string(128)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%billing_parameters}}');

        return true;
    }
}
