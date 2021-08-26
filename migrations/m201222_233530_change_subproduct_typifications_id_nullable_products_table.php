<?php

use yii\db\Migration;

/**
 * Class m201222_233530_change_subproduct_typifications_id_nullable_products_table
 */
class m201222_233530_change_subproduct_typifications_id_nullable_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%products}}', 'subproduct_typifications_id', $this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201222_233530_change_subproduct_typifications_id_nullable_products_table cannot be reverted.\n";

        $this->alterColumn('{{%products}}', 'subproduct_typifications_id', $this->bigInteger()->notNull());

        return true;
    }
}
