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
 * HTTP 请求类
 *
 * @author Winnie <christopher.winnie2012@gmail.com>
 */
class XjtuHttpRequest {

    private static function beforeStatic($method) {
        // We use Request library for http request
        // https://github.com/rmccue/Requests
        if (!class_exists('Requests')) {
            require(dirname(__FILE__) . '/Requests/Requests.php');
            Requests::register_autoloader();
        }
    }

    public static function get($url, $headers = array()) {
        self::beforeStatic(__METHOD__);
        $response = Requests::get($url, $headers);
        if ($response->success) {
            return $response;
        } else {
            throw new XjtuException(__CLASS__ . '::' . __METHOD__ . 'HTTP GET failed:' . $url);
        }
    }

    public static function post($url, $data = null, $headers = array()) {
        self::beforeStatic(__METHOD__);
        $response = Requests::post($url, $headers, $data);
        if ($response->success) {
            return $response;
        } else {
            throw new XjtuException(__CLASS__ . '::' . __METHOD__ . 'HTTP POST failed:' . $url);
        }
    }

}
