<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%providers_id}}`
 */
class m200930_124746_add_providers_id_column_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'providers_id', $this->bigInteger()->notNull());

        // creates index for column `providers_id`
        $this->createIndex(
            '{{%idx-products-providers_id}}',
            '{{%products}}',
            'providers_id'
        );

        // add foreign key for table `{{%providers_id}}`
        $this->addForeignKey(
            '{{%fk-products-providers_id}}',
            '{{%products}}',
            'providers_id',
            '{{%providers}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%providers_id}}`
        $this->dropForeignKey(
            '{{%fk-products-providers_id}}',
            '{{%products}}'
        );

        // drops index for column `providers_id`
        $this->dropIndex(
            '{{%idx-products-providers_id}}',
            '{{%products}}'
        );

        $this->dropColumn('{{%products}}', 'providers_id');

        return true;
    }
}
