<?php
return [
    'bsVersion' => '4.x',
    'adminEmail' => 'a.sakhno@welesgard.com',
    'senderEmail' => 'a.sakhno@welesgard.com',
    'senderName' => 'a.sakhno@welesgard.com Admin',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'user.passwordMinLength' => 8,
    'cookieDomain' => '.welesgard.com',
    'frontendHostInfo' => 'https://frontend.welesgard.test',
    'backendHostInfo' => 'https://backend.welesgard.test',
    'staticHostInfo' => 'https://static.welesgard.test',
    'staticPath' => dirname(__DIR__, 2) . '/static',
    'fileMaxFilesize' => 1024 * 1024 * 2,
    'imageMaxFilesize' => 1024 * 1024 * 2,
    'fileMaxFilesizeKB' => 2000,
    'imageMaxFilesizeKB' => 2000,
];
