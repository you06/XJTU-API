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
 * 缓存类
 *
 * @author Winnie <christopher.winnie2012@gmail.com>
 */
class XjtuCache extends XjtuBase {

    private $dir = null;

    public function __construct() {
        $dir = dirname(__FILE__) . '/Cache/';
        if (!is_writable($dir)) {
            throw new XjtuException(__CLASS__ . '::' . __METHOD__ . ': 缓存文件不存在或不可写.' . $dir . $file);
        } else {
            $this->dir = $dir;
        }
    }

    public function get($name = '') {
        if ($name === '') {
            return false;
        } elseif (!file_exists($this->dir . $name)) {
            return null;
        } else {
            $content = unserialize(file_get_contents($this->dir . $name));
            if (isset($content['expire']) && $content['expire'] < time()) {
                // expired ,wipe out
                $this->set($name, null);
                return null;
            } else {
                return $content['content'];
            }
        }
    }

    public function set($name = '', $value = '', $expire = 0) {
        if ($name === '') {
            return false;
        } elseif (empty($value)) {
            // 清空缓存
            if (file_exists($this->dir . $name)) {
                return unlink($this->dir . $name);
            } else {
                return true;
            }
        } else {
            // 设置缓存
            $content = array();
            $content['content'] = $value;
            if ($expire > 0) {
                $content['expire'] = time() + $expire;
            }
            return file_put_contents($this->dir . $name, serialize($content));
        }
    }

}
