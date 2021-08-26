<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subproduct_typifications}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%subproduct_types}}`
 */
class m200930_124410_create_subproduct_typifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subproduct_typifications}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'name' => $this->string(100)->notNull(),
            'active' => $this->boolean()->notNull(),
            'subproduct_types_id' => $this->bigInteger()->notNull()
        ]);

        // creates index for column `subproduct_types_id`
        $this->createIndex(
            '{{%idx-subproduct_typifications-subproduct_types_id}}',
            '{{%subproduct_typifications}}',
            'subproduct_types_id'
        );

        // add foreign key for table `{{%subproduct_types}}`
        $this->addForeignKey(
            '{{%fk-subproduct_typifications-subproduct_types_id}}',
            '{{%subproduct_typifications}}',
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
            '{{%fk-subproduct_typifications-subproduct_types_id}}',
            '{{%subproduct_typifications}}'
        );

        // drops index for column `subproduct_types_id`
        $this->dropIndex(
            '{{%idx-subproduct_typifications-subproduct_types_id}}',
            '{{%subproduct_typifications}}'
        );

        $this->dropTable('{{%subproduct_typifications}}');

        return true;
    }
}
