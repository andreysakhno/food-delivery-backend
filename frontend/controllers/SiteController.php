<?php

namespace frontend\controllers;

use yii\web\Controller;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public function __construct(
        $id,
        $module,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCart()
    {
        return $this->render('cart');
    }
}
