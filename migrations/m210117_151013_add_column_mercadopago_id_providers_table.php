<?php

use yii\db\Migration;

/**
 * Class m210117_151013_add_column_mercadopago_id_providers_table
 */
class m210117_151013_add_column_mercadopago_id_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%providers}}', 'mercadopago_id', $this->double()->unique());
        // creates index for column `mercadopago_id`
        $this->createIndex(
            '{{%idx-providers-mercadopago_id}}',
            '{{%providers}}',
            'mercadopago_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210117_151013_add_column_mercadopago_id_providers_table cannot be reverted.\n";

        // drops index for column `mercadopago_id`
        $this->dropIndex(
            '{{%idx-providers-mercadopago_id}}',
            '{{%providers}}'
        );

        $this->dropColumn('{{%providers}}', 'mercadopago_id');

        return false;
    }

}
