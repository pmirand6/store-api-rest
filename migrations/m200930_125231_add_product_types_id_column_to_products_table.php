<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product_types}}`
 */
class m200930_125231_add_product_types_id_column_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'product_types_id', $this->bigInteger()->notNull());

        // creates index for column `product_types_id`
        $this->createIndex(
            '{{%idx-products-product_types_id}}',
            '{{%products}}',
            'product_types_id'
        );

        // add foreign key for table `{{%product_types}}`
        $this->addForeignKey(
            '{{%fk-products-product_types_id}}',
            '{{%products}}',
            'product_types_id',
            '{{%product_types}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%product_types}}`
        $this->dropForeignKey(
            '{{%fk-products-product_types_id}}',
            '{{%products}}'
        );

        // drops index for column `product_types_id`
        $this->dropIndex(
            '{{%idx-products-product_types_id}}',
            '{{%products}}'
        );

        $this->dropColumn('{{%products}}', 'product_types_id');

        return true;
    }
}
