<?php
class Path{
    private $path = __DIR__;

    public static function base() {
        return '/galaxify';
    }
    public function basePath(){
        return $this->path;
    }

    public function srcPath(){
        return $this->path . '/src';
    }
}