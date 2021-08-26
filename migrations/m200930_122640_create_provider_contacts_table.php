<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provider_contacts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%providers}}`
 */
class m200930_122640_create_provider_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provider_contacts}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'firstname' => $this->string(50)->notNull(),
            'lastname' => $this->string(50)->notNull(),
            'dni' => $this->string(20)->notNull(),
            'birthday_date' => $this->date()->notNull(),
            'responsable' => $this->boolean()->notNull(),
            'email' => $this->string(50)->notNull(),
            'phone_number' => $this->double()->notNull(),
            'providers_id' => $this->bigInteger()->notNull(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `providers_id`
        $this->createIndex(
            '{{%idx-provider_contacts-providers_id}}',
            '{{%provider_contacts}}',
            'providers_id'
        );

        // add foreign key for table `{{%providers}}`
        $this->addForeignKey(
            '{{%fk-provider_contacts-providers_id}}',
            '{{%provider_contacts}}',
            'providers_id',
            '{{%providers}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%providers}}`
        $this->dropForeignKey(
            '{{%fk-provider_contacts-providers_id}}',
            '{{%provider_contacts}}'
        );

        // drops index for column `providers_id`
        $this->dropIndex(
            '{{%idx-provider_contacts-providers_id}}',
            '{{%provider_contacts}}'
        );

        $this->dropTable('{{%provider_contacts}}');

        return true;
    }
}
