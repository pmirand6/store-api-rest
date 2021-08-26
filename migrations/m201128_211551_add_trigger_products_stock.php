<?php

use yii\db\Migration;

/**
 * Class m201128_211551_add_trigger_products_stock
 */
class m201128_211551_add_trigger_products_stock extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sqlTriggerAfterInsert = <<< SQL
            CREATE DEFINER = CURRENT_USER TRIGGER `trigger_products_stock_AFTER_INSERT_purchases` AFTER INSERT ON `purchases` FOR EACH ROW
            BEGIN
            UPDATE products SET stock = stock - NEW.quantity where products.id = NEW.products_id;
            END
        SQL;

        $this->execute($sqlTriggerAfterInsert);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201128_211551_add_trigger_products_stock cannot be reverted.\n";

        $this->execute('DROP TRIGGER /*!50032 IF EXISTS */ `trigger_products_stock_AFTER_INSERT_purchases`');

        return true;
    }

}
