<?php

namespace frontend\controllers\api;

use model\entities\Food\Shop;
use model\readModels\Food\ShopReadRepository;

use yii\rest\Controller;
use yii\web\Response;

class ShopController extends Controller
{
    private $shops;

    public function __construct(
        $id,
        $module,
        ShopReadRepository $shops,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->shops = $shops;
    }

    protected function verbs(): array
    {
        return [
            'index' => ['GET'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['index'],
                'formats' => [
                   'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter'  => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => [
                        '*',
                    ],
                    'Access-Control-Request-Method' => [
                        'GET',
                        'POST',
                        'PUT',
                        'PATCH',
                        'DELETE',
                        'HEAD',
                        'OPTIONS',
                    ],
                    'Access-Control-Request-Headers' => [
                        '*',
                    ],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $shops = $this->shops->getAll();
        $result = [];
        foreach ($shops as $item) {
            $arr = $this->serializeItem($item);
            array_push($result, $arr);
        }
        return $result;
    }

    public function serializeItem(Shop $shop): array
    {
        return [
            'id' => $shop->id,
            'title' => $shop->title,
            'coords' => $shop->coords,
        ];
    }
}