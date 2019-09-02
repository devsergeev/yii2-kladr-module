<?php

class m190706_134612_kladr_socr extends yii\db\Migration
{
    use devsergeev\yii2KladrModule\migrations\LoadDataInfileTrait;

    public function safeUp()
    {
        $this->createTable('kladr_socr', [
            'level' => $this->tinyInteger(1)->unsigned()->notNull(),
            'scname' => $this->string(10)->notNull(),
            'socrname' => $this->char(29)->notNull(),
            'kod_t_st' => $this->tinyInteger(3)->unsigned()->notNull(),
            'rule' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue('0'),
        ]);

        $this->loadDataInfile('kladr_socr', 'SOCRBASE.csv');

        $this->execute('DELETE FROM `kladr_socr` WHERE `level` NOT IN (1,2,3,4)');

        // TODO если есть таблица kladr_socr_old, то импортировать из неё правила и удалить!!!
    }

    public function safeDown()
    {
        $this->dropTable('kladr_socr');
        // TODO kladr_socr_old переименовать чтобы при следующем апе брать оттуда правила!!!
    }
}
