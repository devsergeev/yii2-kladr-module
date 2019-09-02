<?php

namespace devsergeev\yii2KladrModule\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use devsergeev\yii2KladrModule\models\Kladr;

class DefaultController extends Controller
{
    // TODO по моим наблюдениям в адресе для 4го уровня, лежащего внутри 3го не указывается 3 уровень, если внутри области только один населенный пункт с таким именем
    // TODO пример
    // Вологодская обл., Вытегорский р-н, п. Ужла, д. Озерное-Устье
    // Вологодская обл., Белозерский р-н, д. Устье Артюшинского сельсовета
    // Вологодская обл., Белозерский р-н, д. Устье Городищенского сельсовета

    // https://kladr-api.ru/examples - тут еще одно УСТЬЕ

    public function actionGetRegionList(string $name): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['results' => Kladr::getRegionListForSelect($name)];
    }

    public function actionGetDistrictList(string $name, string $region): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['results' => Kladr::getDistrictListForSelect($name, $region)];
    }

    public function actionGetCityList(string $name, string $region, string $district): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['results' => Kladr::getCityListForSelect($name, $region, $district)];
    }

    public function actionGetLocalityList(string $name, string $region, string $district, string $city): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['results' => Kladr::getLocalityListForSelect($name, $region, $district, $city)];
    }

    public function actionGetAddressByCode(string $code): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Kladr::getAddressByCode($code);
    }
}
