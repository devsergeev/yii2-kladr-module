<?php

namespace devsergeev\yii2KladrModule\models;

use yii\db\Query;

/**
 * @property int $level
 * @property string $scname
 * @property string $socrname
 * @property int $kod_t_st
 */
class KladrSocr
{
    public const REGION   = 1;
    public const DISTRICT = 2;
    public const CITY     = 3;
    public const LOCALITY = 4;

    /**
     * Массив всех строк из таблицы 'kladr_socr'
     * @var array
     */
    private static $rows;
    private static $socr;

    /**
     * @var array если сокращение содержится в этом массиве, то пристыковывать расшифровку сокращения после названия
     * адресного объекта, в иначе пристыковывать до названия
     */
    private static $rule;

    public static function getFull($level, $socr, $name): string
    {
        if (!$socr || !$name) {
            return '';
        }
        self::init();
        //if (isset(self::$socr[$level][$socr])) {
        //    $full = mb_strtolower(self::$socr[$level][$socr]);
        //    if (isset(self::$rule[$level]) && in_array($socr, self::$rule[$level], true)) {
        //        return "$name $full";
        //    }
        //    return "$full $name";
        //}
        return "$socr. $name";
    }

    private static function init(): void
    {
        self::setRows();
        self::setSocr();
        //self::setRule();
    }

    private static function setRows(): void
    {
        if (self::$rows === null) {
            self::$rows  = (new Query())->select(['level', 'scname', 'socrname', 'rule'])->from('kladr_socr')->all();
        }
    }

    private static function setSocr(): void
    {
        if (self::$socr === null) {
            foreach (self::$rows as $row) {
                self::$socr[$row['level']][$row['scname']] = $row['socrname'];
            }
        }
    }

    private static function setRule(): void
    {
        if (self::$rule === null) {
            foreach (self::$rows as $row) {
                if ((int)$row['rule'] === 1) {
                    self::$socr[$row['level']][] = [$row['scname']];
                }
            }
        }
    }
}