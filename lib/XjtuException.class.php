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

/**
 * XjtuException 异常类
 *
 * @author Winnie <christopher.winnie2012@gmail.com>
 */
class XjtuException extends Exception {

    public function __construct($message, $code = -1) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        return __CLASS__ . "[{$this->code}]: {$this->message}\n";
    }

}
