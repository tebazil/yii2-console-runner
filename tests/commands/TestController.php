<?php

/**
 * Created by PhpStorm.
 * User: tebazil
 * Date: 09.08.15
 * Time: 15:51
 */
namespace app\commands;

use yii\console\Controller;

class TestController extends Controller
{

    public function actionTestAction($param) {
        if($param===TEST_INPUT_PARAM) {
            echo \Yii::$app->id;
            return TEST_EXIT_CODE;
        }
    }

}