<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products_has_delivery_types}}`.
 */
class m201030_012254_create_products_has_delivery_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products_has_delivery_types}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'products_id' => $this->bigInteger()->notNull(),
            'delivery_types_id' => $this->bigInteger()->notNull(),
        ]);

        // creates index for column `products_id`
        $this->createIndex(
            '{{%idx-products_has_delivery_types-products_id}}',
            '{{%products_has_delivery_types}}',
            'products_id'
        );

        // add foreign key for table `{{%delivery_types}}`
        $this->addForeignKey(
            '{{%fk-products_has_delivery_types-products_id}}',
            '{{%products_has_delivery_types}}',
            'products_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );

        // creates index for column `delivery_types_id`
        $this->createIndex(
            '{{%idx-products_has_delivery_types-delivery_types_id}}',
            '{{%products_has_delivery_types}}',
            'delivery_types_id'
        );

        // add foreign key for table `{{%delivery_types}}`
        $this->addForeignKey(
            '{{%fk-products_has_delivery_types-delivery_types_id}}',
            '{{%products_has_delivery_types}}',
            'delivery_types_id',
            '{{%delivery_types}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-products_has_delivery_types-products_id}}',
            '{{%products_has_delivery_types}}'
        );

        // drops index for column `products_id`
        $this->dropIndex(
            '{{%idx-products_has_delivery_types-products_id}}',
            '{{%products_has_delivery_types}}'
        );
        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-products_has_delivery_types-delivery_types_id}}',
            '{{%products_has_delivery_types}}'
        );

        // drops index for column `delivery_types_id`
        $this->dropIndex(
            '{{%idx-products_has_delivery_types-delivery_types_id}}',
            '{{%products_has_delivery_types}}'
        );

        $this->dropTable('{{%products_has_delivery_types}}');

        return true;
    }
}
