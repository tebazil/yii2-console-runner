<?php
/**
 * Created by PhpStorm.
 * User: tebazil
 * Date: 09.08.15
 * Time: 15:56
 */

namespace tests;


use tebazil\runner\ConsoleCommandRunner;
use Yii;

class RunnerTest extends \PHPUnit_Framework_TestCase
{
    public function testRunner() {
        $this->assertEquals(OUTER_APPLICATION_ID, Yii::$app->id);
        $runner = new ConsoleCommandRunner([
            'id' => INNER_APPLICATION_ID,
            'basePath' => __DIR__,
            'controllerNamespace'=>'app\commands'
        ]);
        $this->assertEquals(OUTER_APPLICATION_ID, Yii::$app->id);
        $runner->run('test/test-action', [TEST_INPUT_PARAM]);
        $this->assertEquals(OUTER_APPLICATION_ID, Yii::$app->id);

        $this->assertEquals($runner->getOutput(),INNER_APPLICATION_ID);
        $this->assertEquals($runner->getExitCode(),TEST_EXIT_CODE);
    }
}