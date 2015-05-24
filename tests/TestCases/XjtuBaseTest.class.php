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

abstract class XjtuBaseTest {

    public function __construct() {

        $this->init();
    }

    public static function autoLoader($class) {
        if (file_exists(dirname(__FILE__) . '/' . $class . '.class.php')) {
            require(dirname(__FILE__) . '/' . $class . '.class.php');
        }
    }

    abstract public function init();

    abstract public function run();

    protected function show($msg, $expression = '__not_display__') {
        $var_text = ($expression === '__not_display__') ? '' : ': ' . var_export($expression, true);
        echo '[UnitTest] ' . $msg . $var_text . "\n";
    }

    public function startClock() {
        $this->_startTime = microtime(true);
    }

    protected function stopClock() {
        $this->_stopTime = microtime(true);
        echo '[UnitTest] The Clock Time is: ' . (($this->_stopTime) - ($this->_startTime)) . "\n";
    }

}
