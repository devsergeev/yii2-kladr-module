<?php

class m190705_172802_kladr extends yii\db\Migration
{
    use devsergeev\yii2KladrModule\migrations\LoadDataInfileTrait;

    public function safeUp()
    {
        $this->createTable('kladr', [
            'name' => $this->string(40)->notNull(),
            'socr' => $this->string(10)->notNull(),
            'code' => $this->char(13)->notNull(),
            'index' => $this->char(6)->notNull(),
            'gninmb' => $this->char(4)->notNull(),
            'uno' => $this->char(4)->notNull(),
            'ocatd' => $this->char(11)->notNull(),
            'status' => $this->tinyInteger(1)->unsigned()->notNull(),
        ]);

        $this->loadDataInfile('kladr', 'KLADR.csv');

        $this->dropColumn('kladr', 'index');
        $this->dropColumn('kladr', 'gninmb');
        $this->dropColumn('kladr', 'uno');
        $this->dropColumn('kladr', 'ocatd');

        $this->createIndex('idx-kladr-status', 'kladr', 'status');

        $this->execute("DELETE FROM `kladr` WHERE SUBSTR(`code`, 12, 13) != '00'");
        $this->execute('UPDATE `kladr` SET `code` = SUBSTR(`code`, 1, 11)');
        $this->alterColumn('kladr', 'code', 'CHAR(11) NOT NULL');

        $this->addColumn('kladr', 'region', 'SMALLINT(2) UNSIGNED NOT NULL');
        $this->addColumn('kladr', 'district', 'SMALLINT(3) UNSIGNED NOT NULL');
        $this->addColumn('kladr', 'city', 'SMALLINT(3) UNSIGNED NOT NULL');
        $this->addColumn('kladr', 'locality', 'SMALLINT(3) UNSIGNED NOT NULL');

        $this->execute('UPDATE kladr SET region = SUBSTR(code, 1, 2), district = SUBSTR(CODE, 3, 3), city = SUBSTR(CODE, 6, 3), locality = SUBSTR(CODE, 9, 3)');

        $this->createIndex('idx-kladr-region', 'kladr', 'region');
        $this->createIndex('idx-kladr-district', 'kladr', 'district');
        $this->createIndex('idx-kladr-city', 'kladr', 'city');
        $this->createIndex('idx-kladr-locality', 'kladr', 'locality');

        $this->addColumn('kladr', 'level', 'TINYINT(1) UNSIGNED NOT NULL');
        $this->execute('UPDATE kladr SET level = 1 WHERE region != 0 AND district = 0 AND city = 0 AND locality = 0');
        $this->execute('UPDATE kladr SET level = 2 WHERE region != 0 AND district != 0 AND city = 0 AND locality = 0');
        $this->execute('UPDATE kladr SET level = 3 WHERE region != 0 AND city != 0 AND locality = 0');
        $this->execute('UPDATE kladr SET level = 4 WHERE region != 0 AND locality != 0');
        $this->createIndex('idx-kladr-level', 'kladr', 'level');
    }

    public function safeDown()
    {
        $this->dropTable('kladr');
    }
}
