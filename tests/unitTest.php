<?php

/*
 * Copyright 2015 Winnie <christopher.winnie2012@gmail.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// Load XJTU-API Lib
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'autoLoader.php');
// Load BaseTest Lib
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'TestCases' . DIRECTORY_SEPARATOR . 'XjtuBaseTest.class.php');
// 注册单元测试autoloader
spl_autoload_register('XjtuBaseTest::autoLoader');

if (php_sapi_name() != 'cli') {
    die('[Error] Unit Test can only be running under CLI mode.');
}
if ($_SERVER['argc'] != 2) {
    die('Usage: php ' . basename(__FILE__) . ' [ClassName]');
}
if (class_exists($_SERVER['argv'][1])) {
    $class_name = $_SERVER['argv'][1] . 'Test';
    $t = new $class_name();
    $t->run();
} else {
    die('[Error] ' . $_SERVER['argv'][1] . ' class didn\'t exists. Haven\'t write TestCase?');
}
