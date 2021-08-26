<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%qualification_votes}}`.
 */
class m201211_223026_create_qualification_votes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%qualification_votes}}', [
            'id' => $this->bigPrimaryKey(),
            'qualifications_id' => $this->bigInteger()->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'liked' => $this->boolean(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `qualifications_id`
        $this->createIndex(
            '{{%idx-qualification_votes-qualifications_id}}',
            '{{%qualification_votes}}',
            'qualifications_id'
        );

        // add foreign key for table `{{%qualifications}}`
        $this->addForeignKey(
            '{{%fk-qualification_votes-qualifications_id}}',
            '{{%qualification_votes}}',
            'qualifications_id',
            '{{%qualifications}}',
            'id',
            'CASCADE'
        );

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-qualification_votes-clients_id}}',
            '{{%qualification_votes}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-qualification_votes-clients_id}}',
            '{{%qualification_votes}}',
            'clients_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%qualifications}}`
        $this->dropForeignKey(
            '{{%fk-qualification_votes-qualifications_id}}',
            '{{%qualification_votes}}'
        );

        // drops index for column `qualifications_id`
        $this->dropIndex(
            '{{%idx-qualification_votes-qualifications_id}}',
            '{{%qualification_votes}}'
        );
        
        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-qualification_votes-clients_id}}',
            '{{%qualification_votes}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-qualification_votes-clients_id}}',
            '{{%qualification_votes}}'
        );

        $this->dropTable('{{%qualification_votes}}');

        return true;
    }
}
