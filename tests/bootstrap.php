<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__.'/../src/ConsoleCommandRunner.php'); //?? before composer

Yii::setAlias('@tests', __DIR__);

const OUTER_APPLICATION_ID = 'outer_application';
const INNER_APPLICATION_ID = 'inner_application';
const TEST_INPUT_PARAM = 'test input param';
const TEST_ECHO_TEXT = 'test echo text';
const TEST_EXIT_CODE = 2;

new \yii\console\Application([
    'id' => OUTER_APPLICATION_ID,
    'basePath' => __DIR__,
]);