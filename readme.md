# Yii2 console command runner

Another implementation of Yii2 console command runner. At the time of writing this, it differs from
[vova07/yii2-console-runner-extension](https://github.com/vova07/yii2-console-runner-extension) and [toriphes/yii2-console-runner] (https://github.com/toriphes/yii2-console-runner) in that it doesn't require shell_exec to be enabled on the server.

Typical usage would be to run `migrate` or other of your console application's commands from web application's controller's action.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require tebazil/yii2-console-runner
```

or add

```
"tebazil/yii2-console-runner": "*"
```

to the `require` section of your `composer.json` file.

## Basic usage

First you initialize the runner.

```php
$runner = \tebazil\runner\ConsoleCommandRunner();
```

Then you run as many commands as you need:

```php
$runner->run('migrate');
$runner->run('migrate\create', ['insert_test_id','interactive'=>false]);
```

After running each command, you may collect get the exitCode and/or output for the last command.

```php
$output = $runner->getOutput();
$exitCode = $runner->getExitCode();
```

##How it works
On initialization, the runner creates a new console application, then it returns `Yii::$app` to the application currently executed. When running the command, runner will first replace the `Yii::$app` with the "child" console application, run the command, and replace Yii::$app back with the parent application.
The result is that in console commands you have console application's `Yii::$app`, and between the runs `Yii::$app` is your "parent" application, as it was intended.

##Advanced usage
You can optionally pass the `$config` (path or array) to the `ConsoleCommandRunner::__construct` method, so you can alter console application's configuration on the fly. You might also want to create several runners with different configured applications - each will stick to it's own application, and will respore original `Yii::$app` between runs.

##Known issues
Currently only `echo` output can be retrieved with `getOutput`, because standart `ob_start/ob_get_clean` combination is used to capture the output. If output is being written directly to `stdout` or `stderr`, it won't be captured.