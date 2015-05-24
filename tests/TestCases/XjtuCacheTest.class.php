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
 * Description of XjtuCacheTest
 *
 * @author Winnie <christopher.winnie2012@gmail.com>
 */
class XjtuCacheTest extends XjtuBaseTest {

    public function init() {
        $this->content = array('123', '456', True);
    }

    public function run() {
        $c = new XjtuCache();
        $c->set(__CLASS__, $this->content, 10);
        //$c->set(__CLASS__, '');
        $content = $c->get(__CLASS__);
        $this->show('Content', $content);
    }

}
