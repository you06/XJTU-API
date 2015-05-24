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
 * XJTU-CAS中央认证系统 API
 *
 * @author Winnie <christopher.winnie2012@gmail.com>
 */
class XjtuCas extends XjtuBase {

    private static $server = 'https://cas.xjtu.edu.cn';
    private $netid = '';
    private $pass = '';
    private $castgc = null;
    private $valid = null;

    public function __construct($netid = '', $pass = '') {
        $this->netid = $netid;
        $this->pass = $pass;
    }

    public function setUser($netid, $pass) {
        if (is_string($netid) && is_string($pass)) {
            $this->netid = $netid;
            $this->pass = $pass;
            $this->getCache($netid);
            return true;
        } else {
            throw new XjtuException(__CLASS__ . '::' . __METHOD__ . ': $netid and $pass must be string.');
        }
    }

    public function login() {
        // average: 2.3s
        if ($this->netid == '' || $this->pass == '') {
            return false;
        }
        $url = self::$server . '/login';
        $response = XjtuHttpRequest::get($url);
        // 提取JSESSIONID
        $cookie = $response->cookies->offsetGet('JSESSIONID');
        $jsessionid = $cookie->value;
        unset($cookie);
        // 提取LT
        preg_match('/<input.+value\=\"LT-(.*)\" \/>/iu', $response->body, $LTes);
        $lt = 'LT-' . $LTes [1];
        unset($LTes);
        // 提取execution
        preg_match('/<input.+name\=\"execution\".+value=\"(.*)\" \/>/iu', $response->body, $executiones);
        $execution = $executiones[1];
        unset($executiones);
        // Login Params
        $loginParams = array(
            'username' => $this->netid,
            'password' => $this->pass,
            'lt' => $lt,
            'execution' => $execution,
            '_eventId' => 'submit',
            'submit' => '%E7%99%BB%E5%BD%95',
            'code' => ''
        );
        // Cookie
        $headers = array('Cookie' => 'JSESSIONID=' . $jsessionid);
        $response = XjtuHttpRequest::post($url, $loginParams, $headers);
        // 提取CASTGC票根
        if ($response->cookies->offsetGet('CASTGC') != Null) {
            $this->castgc = $response->cookies->offsetGet('CASTGC')->value;
            $this->setCache();
            $this->valid = true;
            return true;
        } else {
            $this->valid = false;
            return false;
        }
    }

    public function isValid() {
        if (!$this->valid) {
            if ($this->castgc) {
                $this->checkCastgc();
            }
            if (!$this->valid) {
                $this->login();
            }
        }
        return $this->valid;
    }

    public function checkCastgc() {
        // average: 0.6s
        $url = self::$server . '/login';
        $headers = array('Cookie' => 'CASTGC=' . $this->castgc);
        $response = XjtuHttpRequest::get($url, $headers);
        if (strpos($response->body, '您已经成功登录中央认证系统') === false) {
            $this->valid = false;
            // 清除castgc
            $this->castgc = null;
            $this->setCache();
            return false;
        } else {
            $this->valid = true;
            return true;
        }
    }

    public function setCache() {
        $cache = new XjtuCache();
        $uInfo = array(
            'netid' => $this->netid,
            'pass' => $this->pass,
            'castgc' => $this->castgc,
        );
        $name = __CLASS__ . '-' . substr(sha1($this->netid), 10, 15);
        $cache->set($name, $uInfo);
    }

    public function getCache($netid) {
        $cache = new XjtuCache();
        $name = __CLASS__ . '-' . substr(sha1($netid), 10, 15);
        $uInfo = $cache->get($name);
        if ($uInfo) {
            $this->netid = $uInfo['netid'];
            //$this->pass = $uInfo['pass'];
            $this->valid = false;
            $this->castgc = $uInfo['castgc'];
            return true;
        } else {
            return false;
        }
    }

}
