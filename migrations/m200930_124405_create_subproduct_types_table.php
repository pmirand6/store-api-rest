<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subproduct_types}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product_types}}`
 */
class m200930_124405_create_subproduct_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subproduct_types}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'name' => $this->string(100)->notNull(),
            'active' => $this->boolean()->notNull(),
            'product_types_id' => $this->bigInteger()->notNull()
        ]);

        // creates index for column `product_types_id`
        $this->createIndex(
            '{{%idx-subproduct_types-product_types_id}}',
            '{{%subproduct_types}}',
            'product_types_id'
        );

        // add foreign key for table `{{%product_types}}`
        $this->addForeignKey(
            '{{%fk-subproduct_types-product_types_id}}',
            '{{%subproduct_types}}',
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
            '{{%fk-subproduct_types-product_types_id}}',
            '{{%subproduct_types}}'
        );

        // drops index for column `product_types_id`
        $this->dropIndex(
            '{{%idx-subproduct_types-product_types_id}}',
            '{{%subproduct_types}}'
        );

        $this->dropTable('{{%subproduct_types}}');

        return true;
    }
}
