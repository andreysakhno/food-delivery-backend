<?php

/** @var array $params */

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['frontendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        'cart' => 'site/cart',
        'history' => 'site/history',

        'GET api/shops' => 'api/shop/index',
        'GET api/foods' => 'api/food/index',
        'POST api/orders' => 'api/order/create',
        'GET api/orders' => 'api/order/index',
    ],
];