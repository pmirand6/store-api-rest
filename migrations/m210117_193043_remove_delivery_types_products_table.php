<?php

use yii\db\Migration;

/**
 * Class m210117_193043_remove_delivery_types_products_table
 */
class m210117_193043_remove_delivery_types_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%products}}', 'delivery_types');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210117_193043_remove_delivery_types_products_table cannot be reverted.\n";

        $this->addColumn('{{%products}}', 'delivery_types',  $this->text()->notNull());
        
        return false;
    }
}
