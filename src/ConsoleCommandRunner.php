<?php

namespace tebazil\runner;

class ConsoleCommandRunner
{
    private $outerApplication;
    private $innerApplication;
    private $output;
    private $exitCode;

    public function __construct($config = null)
    {
        if (is_null($config)) {
            $config = \Yii::getAlias('@app/config/console.php');
        }

        if(is_string($config)) {
            if (is_file($file = \Yii::getAlias($config))) {
                $config = require($file);
            }
            else {
                throw new \InvalidArgumentException('if $config is a string, it should be a valid yii file path');
            }

        }
        if(!is_array($config)) {
            throw new \InvalidArgumentException('$config should either be a string (path) or array');
        }
        // fcgi doesn't have STDIN and STDOUT defined by default
        defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
        defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
        $this->outerApplication = \Yii::$app;
        $this->innerApplication = new \yii\console\Application($config); //this changes \Yii::$app;
        \Yii::$app=$this->outerApplication; //we set it back
    }

    public function run($route, array $params = [])
    {
        $this->output = null;
        $this->exitCode = null;
        \Yii::$app=$this->innerApplication; //Yii::$app references to console application, while you are running your command
        ob_start();
        $this->exitCode = $this->innerApplication->runAction($route, $params);
        $this->output = ob_get_clean();
        \Yii::$app=$this->outerApplication; //now Yii::$app is outer application again (typically web application)
        return $this;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getExitCode()
    {
        return $this->exitCode;
    }

}