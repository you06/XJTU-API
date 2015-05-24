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

class XjtuCasTest extends XjtuBaseTest {

    public function init() {
        $this->netid = 'admin';
        $this->pass = 'password';
    }

    public function run() {
        $user = new XjtuCas();
        $user->setUser($this->netid, $this->pass);
        $this->show('netid', $this->netid);
        $this->startClock();
        $this->show('isValid', $user->isValid());
        $this->stopClock();
    }

}
