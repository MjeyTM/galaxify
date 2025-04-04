<?php
session_start([
    'cookie_lifetime' => 7200,  // 2 hour
    'cookie_httponly' => true,  // Protect from JS access
]);
date_default_timezone_set('Asia/Tehran');