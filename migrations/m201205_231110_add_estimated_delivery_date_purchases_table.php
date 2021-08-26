<?php

use yii\db\Migration;

/**
 * Class m201205_231110_add_estimated_delivery_date_purchases_table
 */
class m201205_231110_add_estimated_delivery_date_purchases_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%purchases}}', 'estimated_delivery_date', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201205_231110_add_estimated_delivery_date_purchases_table cannot be reverted.\n";
        $this->dropColumn('{{%purchases}}', 'estimated_delivery_date');

        return true;
    }
}
