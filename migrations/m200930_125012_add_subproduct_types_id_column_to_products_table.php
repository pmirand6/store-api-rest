<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%subproduct_types}}`
 */
class m200930_125012_add_subproduct_types_id_column_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'subproduct_types_id', $this->bigInteger()->notNull());

        // creates index for column `subproduct_types_id`
        $this->createIndex(
            '{{%idx-products-subproduct_types_id}}',
            '{{%products}}',
            'subproduct_types_id'
        );

        // add foreign key for table `{{%subproduct_types}}`
        $this->addForeignKey(
            '{{%fk-products-subproduct_types_id}}',
            '{{%products}}',
            'subproduct_types_id',
            '{{%subproduct_types}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%subproduct_types}}`
        $this->dropForeignKey(
            '{{%fk-products-subproduct_types_id}}',
            '{{%products}}'
        );

        // drops index for column `subproduct_types_id`
        $this->dropIndex(
            '{{%idx-products-subproduct_types_id}}',
            '{{%products}}'
        );

        $this->dropColumn('{{%products}}', 'subproduct_types_id');

        return true;
    }
}
