<?php

use yii\db\Migration;

/**
 * Class m201127_184223_add_trigger_addresses_geo
 */
class m201127_184223_add_trigger_addresses_geo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sqlTriggerBeforeInsert = <<< SQL
            CREATE DEFINER = CURRENT_USER TRIGGER `addresses_generate_geo_BEFORE_INSERT` BEFORE INSERT ON `addresses` FOR EACH ROW
            BEGIN
                SET NEW.geo = ST_GeomFromText(concat("point(", NEW.latitude," ",NEW.longitude,")"),4326);
            END
        SQL;

        $this->execute($sqlTriggerBeforeInsert);

        $sqlTriggerBeforeUpdate = <<< SQL
            CREATE DEFINER = CURRENT_USER TRIGGER `addresses_generate_geo_BEFORE_UPDATE` BEFORE UPDATE ON `addresses` FOR EACH ROW
            BEGIN
                SET NEW.geo = ST_GeomFromText(concat("point(", NEW.latitude," ",NEW.longitude,")"),4326);
            END
        SQL;

        $this->execute($sqlTriggerBeforeUpdate);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201127_184223_add_trigger_addresses_geo cannot be reverted.\n";

        $this->execute('DROP TRIGGER /*!50032 IF EXISTS */ `addresses_generate_geo_BEFORE_INSERT`');
        $this->execute('DROP TRIGGER /*!50032 IF EXISTS */ `addresses_generate_geo_BEFORE_UPDATE`');

        return true;
    }
}
