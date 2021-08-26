<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m200930_032041_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'name' => $this->string(100)->notNull(),
            'presentation' => $this->text(),
            'volumes_name' => $this->string(30)->notNull(),
            'volume_value' => $this->double()->notNull(),
            'weights_name' => $this->string(30)->notNull(),
            'weight_value' => $this->double()->notNull(),
            'requires_cold' => $this->boolean()->defaultValue(0)->notNull(),
            // TODO trigger que actualza clacification
            'clasification' => $this->decimal(2)->notNull()->defaultValue(0.00),
            'stock' => $this->bigInteger()->notNull(),
            'price' => $this->double()->notNull(),
            'reposition_point' => $this->bigInteger()->notNull(),
            'delivery_time' => $this->bigInteger()->notNull()->defaultValue(0),
            'expires' => $this->bigInteger()->notNull(),
            'expires_time' => $this->bigInteger()->notNull(),
            'status' => "ENUM('pendiente', 'habilitado', 'rechazado', 'eliminado') default 'pendiente' NOT NULL",
            'active' => $this->boolean()->notNull(),
            'delivery_types' => $this->text()->notNull(),
            'videos' => $this->text(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');

        return true;
    }
}
