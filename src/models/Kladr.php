<?php

// TODO добавить федеральные округа

namespace devsergeev\yii2KladrModule\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * @property string $name
 * @property string $socr
 * @property string $code
    СС РРР ГГГ ППП
    СС – код субъекта Российской Федерации (региона);
    РРР – код района;
    ГГГ – код города;
    ППП – код населенного пункта,
 * @property int $status Блок "Статус объекта" содержит значение признака (“признак центра”), которое определяет,
    является ли данный адресный объект центром административно - территориального образования: столицей республики,
    центром края, области, района и т.п. Длина – 1 разряд. Данный блок может содержать следующие значения:
    0 - объект не является центром административно-территориального образования;
    1 – объект является центром района;
    2 – объект является центром (столицей) региона;
    3 – объект является одновременно и центром района и центром региона;
    4 – центральный район, т.е. район, в котором находится центр региона (только для объектов 2-го уровня).
    Блок "Статус объекта" предназначен для правильного формирования почтового адреса с использованием базы данных КЛАДР:
    если значением этого поля является “1”, то в адресе указываются регион и населенный пункт (район не указывается);
    если – “2” или “3”, то в адресе указывается только центр региона (регион и район не указываются).
 * @property int $region
 * @property int $district
 * @property int $city
 * @property int $locality
 * @property int $level
 */
class Kladr extends ActiveRecord
{
    private const REGION   = 1;
    private const DISTRICT = 2;
    private const CITY     = 3;
    private const LOCALITY = 4;

    public static function getAddressByCode(string $code): array
    {
        if (preg_match('/(\d{2})(\d{3})(\d{3})(\d{3})/', $code, $matches)) {
            foreach ([self::LOCALITY, self::CITY, self::DISTRICT, self::REGION] as $level) {
                if (isset($matches[$level]) && $value = (int)$matches[$level]) {
                    return self::getList(
                        $level,
                        null,
                        (int)$matches[self::REGION],
                        (int)$matches[self::DISTRICT],
                        (int)$matches[self::CITY],
                        (int)$matches[self::LOCALITY]
                    )[0];
                }
            }
        }
        return [];
    }

    public static function getStringAddressByCode(string $code): string
    {
        $addresStr = '';
        $addressArr = self::getAddressByCode($code);
        $indexArr = [
            'pSocrRegion',
            'pNameRegion',
            'pSocrDistrict',
            'pNameDistrict',
            'pSocrCity',
            'pNameCity',
            'socr',
            'name'
        ];
        foreach ($indexArr as $index) {
            if (isset($addressArr[$index])) {
                $addresStr .= $addressArr[$index] . (stripos($index, 'socr') !== false ? '.' : ',') . ' ';
            }
        }
        $addresStr = trim($addresStr, ', ');
        return $addresStr;
    }

    public static function getRegionListForSelect(string $name): array
    {
        $result = [];
        foreach (self::getRegionList($name) as $row) {
            $result[] = [
                'id' => $row['code'],
                'text' => KladrSocr::getFull(self::DISTRICT, $row['socr'], $row['name']),
            ];
        }
        return $result;
    }

    public static function getDistrictListForSelect(string $name, string $region): array
    {
        $result = [];
        foreach (self::getDistrictList($name, (int)$region) as $row) {
            $result[] = [
                'region' => [
                    'id' => $row['pCodeRegion'],
                    'text' => KladrSocr::getFull(self::DISTRICT, $row['pSocrRegion'], $row['pNameRegion']),
                ],
                'id' => $row['code'],
                'text' => KladrSocr::getFull(self::DISTRICT, $row['socr'], $row['name']),
            ];
        }
        return $result;
    }

    public static function getCityListForSelect(string $name, string $region, string $district): array
    {
        $result = [];
        foreach (self::getCityList($name, (int)$region, (int)$district) as $row) {
            $result[] = [
                'region' => [
                    'id' => $row['pCodeRegion'],
                    'text' => KladrSocr::getFull(self::DISTRICT, $row['pSocrRegion'], $row['pNameRegion']),
                ],
                'district' => [
                    'id' => $row['pCodeDistrict'],
                    'text' => KladrSocr::getFull(self::DISTRICT, $row['pSocrDistrict'], $row['pNameDistrict']),
                ],
                'id' => $row['code'],
                'text' => KladrSocr::getFull(self::CITY, $row['socr'], $row['name']),
            ];
        }
        return $result;
    }

    public static function getLocalityListForSelect(string $name, string $region, string $district, string $city): array
    {
        $result = [];
        foreach (self::getLocalityList($name, (int)$region, (int)$district, (int)$city) as $row) {
            $result[] = [
                'region' => [
                    'id' => $row['pCodeRegion'],
                    'text' => KladrSocr::getFull(self::DISTRICT, $row['pSocrRegion'], $row['pNameRegion']),
                ],
                'district' => [
                    'id' => $row['pCodeDistrict'],
                    'text' => KladrSocr::getFull(self::DISTRICT, $row['pSocrDistrict'], $row['pNameDistrict']),
                ],
                'city' => [
                    'id' => $row['pCodeCity'],
                    'text' => KladrSocr::getFull(self::DISTRICT, $row['pSocrCity'], $row['pNameCity']),
                ],
                'id' => $row['code'],
                'text' => KladrSocr::getFull(self::LOCALITY, $row['socr'], $row['name']),
            ];
        }
        return $result;
    }

    private static function getRegionList(string $name): array
    {
        return self::getList(self::REGION, $name);
    }

    private static function getDistrictList(string $name, int $region): array
    {
        return self::getList(self::DISTRICT, $name, $region);
    }

    private static function getCityList(string $name, int $region, int $district): array
    {
        return self::getList(self::CITY, $name, $region, $district);
    }

    private static function getLocalityList(string $name, int $region, int $district, int $city): array
    {
        return self::getList(self::LOCALITY, $name, $region, $district, $city);
    }

    private static function getList(
        int $level,
        string $name = null,
        int $region = null,
        int $district = null,
        int $city = null,
        int $locality = null
    ): array
    {
        $query = (new Query())->from('kladr AS t1');
        $select = ['t1.code', 't1.region', 't1.district', 't1.city', 't1.locality', 't1.socr', 't1.name', 't1.level'];
        switch ($level) {
            case self::REGION:
                $select = array_merge($select, [
                    '(NULL) AS pCodeRegion',
                    '(NULL) AS pSocrRegion',
                    '(NULL) AS pNameRegion',
                    '(NULL) AS pCodeDistrict',
                    '(NULL) AS pSocrDistrict',
                    '(NULL) AS pNameDistrict',
                    '(NULL) AS pCodeCity',
                    '(NULL) AS pSocrCity',
                    '(NULL) AS pNameCity',
                ]);
                break;
            case self::DISTRICT:
                $select = array_merge($select, [
                    't2.code AS pCodeRegion',
                    't2.socr AS pSocrRegion',
                    't2.name AS pNameRegion',
                    '(NULL) AS pCodeDistrict',
                    '(NULL) AS pSocrDistrict',
                    '(NULL) AS pNameDistrict',
                    '(NULL) AS pCodeCity',
                    '(NULL) AS pSocrCity',
                    '(NULL) AS pNameCity',
                ]);
                $query->innerJoin('kladr AS t2', 't1.region = t2.region AND t2.level = ' . self::REGION);
                break;
            case self::CITY:
                $select = array_merge($select, [
                    't2.code AS pCodeRegion',
                    't2.socr AS pSocrRegion',
                    't2.name AS pNameRegion',
                    't3.code AS pCodeDistrict',
                    't3.socr AS pSocrDistrict',
                    't3.name AS pNameDistrict',
                    '(NULL) AS pCodeCity',
                    '(NULL) AS pSocrCity',
                    '(NULL) AS pNameCity',
                ]);
                $query->innerJoin('kladr AS t2', 't1.region = t2.region AND t2.level = ' . self::REGION);
                $query->leftJoin('kladr AS t3', 't1.region = t3.region AND t1.district = t3.district AND t3.level = ' .self::DISTRICT);
                break;
            case self::LOCALITY:
                $select = array_merge($select, [
                    't2.code AS pCodeRegion',
                    't2.socr AS pSocrRegion',
                    't2.name AS pNameRegion',
                    't3.code AS pCodeDistrict',
                    't3.socr AS pSocrDistrict',
                    't3.name AS pNameDistrict',
                    't4.code AS pCodeCity',
                    't4.socr AS pSocrCity',
                    't4.name as pNameCity'
                ]);
                $query->innerJoin('kladr AS t2', 't1.region = t2.region AND t2.level = ' . self::REGION);
                $query->leftJoin('kladr AS t3', 't1.region = t3.region AND t1.district = t3.district AND t3.level = ' . self::DISTRICT);
                $query->leftJoin('kladr AS t4', 't1.region = t4.region AND t1.district = t4.district AND t1.city = t4.city AND t4.level = ' . self::CITY);
                break;
        }

        $query->select($select)->where(['t1.level' => $level]);

        if ($region) {
            $query->andWhere(['t1.region' => $region]);
        }
        if ($district) {
            $query->andWhere(['t1.district' => $district]);
        }
        if ($city) {
            $query->andWhere(['t1.city' => $city]);
        }
        if ($locality) {
            $query->andWhere(['t1.locality' => $locality]);
        }
        if ($name) {
            $query->andWhere(['like', 't1.name', $name]);
        }
        if ($level !== self::REGION) {
            $query->limit(10);
        }

        return $query->all();
    }
}
