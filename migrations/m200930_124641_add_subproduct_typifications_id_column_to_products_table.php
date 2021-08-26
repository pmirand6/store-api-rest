<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%subproduct_typifications}}`
 */
class m200930_124641_add_subproduct_typifications_id_column_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'subproduct_typifications_id', $this->bigInteger()->notNull());

        // creates index for column `subproduct_typifications_id`
        $this->createIndex(
            '{{%idx-products-subproduct_typifications_id}}',
            '{{%products}}',
            'subproduct_typifications_id'
        );

        // add foreign key for table `{{%subproduct_typifications}}`
        $this->addForeignKey(
            '{{%fk-products-subproduct_typifications_id}}',
            '{{%products}}',
            'subproduct_typifications_id',
            '{{%subproduct_typifications}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%subproduct_typifications}}`
        $this->dropForeignKey(
            '{{%fk-products-subproduct_typifications_id}}',
            '{{%products}}'
        );

        // drops index for column `subproduct_typifications_id`
        $this->dropIndex(
            '{{%idx-products-subproduct_typifications_id}}',
            '{{%products}}'
        );

        $this->dropColumn('{{%products}}', 'subproduct_typifications_id');

        return true;
    }
}
