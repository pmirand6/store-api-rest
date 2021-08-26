<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%providers}}`.
 */
class m200930_121705_create_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%providers}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'name' => $this->string(100)->notNull(),
            'business_name' => $this->string(100)->notNull(),
            // TODO trigger que actualza clacification
            'clasification' => $this->decimal(2)->notNull()->defaultValue(0.00),
            'geo' => 'POINT NOT NULL SRID 4326',
            'latitude' => $this->double()->notNull(),
            'longitude' => $this->double()->notNull(),
            //TODO agregar localidades_id se borraron country, statets y regions
            'street_name' => $this->string(30)->notNull(),
            'floor' => $this->string(10),
            'department_number' => $this->string(6),
            'training' => $this->boolean()->notNull(),
            'logo' => $this->string(100),
            'cbu' => $this->string(22)->notNull(),
            'phone_number' => $this->double()->notNull(),
            'email' => $this->string(150)->notNull(),
            'participate_fairs' => $this->boolean()->notNull(),
            'signature' => $this->boolean()->defaultValue(false),
            'signature_date' => $this->date(),
            'active' => $this->boolean()->notNull()->defaultValue(true),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->execute('CREATE SPATIAL INDEX idx_geo_index on '.'{{%providers}}(geo);');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%providers}}');

        return true;
    }
}
