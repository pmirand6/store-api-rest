<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_images}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%products}}`
 */
class m200930_114907_create_product_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_images}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'image' => $this->text()->notNull(),
            'products_id' => $this->bigInteger()->notNull()
        ]);

        // creates index for column `products_id`
        $this->createIndex(
            '{{%idx-product_images-products_id}}',
            '{{%product_images}}',
            'products_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-product_images-products_id}}',
            '{{%product_images}}',
            'products_id',
            '{{%products}}',
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
            '{{%fk-product_images-products_id}}',
            '{{%product_images}}'
        );

        // drops index for column `products_id`
        $this->dropIndex(
            '{{%idx-product_images-products_id}}',
            '{{%product_images}}'
        );

        $this->dropTable('{{%product_images}}');

        return true;
    }
}
