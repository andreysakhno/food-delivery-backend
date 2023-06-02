<?php

namespace frontend\controllers\api;

use model\entities\Food\Food;
use model\readModels\Food\FoodReadRepository;

use model\widgets\ImgOpt;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class FoodController extends Controller
{
    private $foods;

    public function __construct(
        $id,
        $module,
        FoodReadRepository $foods,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->foods = $foods;
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
        $shopIds = Yii::$app->request->get('shopIds');

        if (empty($shopIds)) {
            $foods = $this->foods->getAll();
        } else {
            $shopIdsArr = explode(",", $shopIds);
            $foods = $this->foods->getByShopId($shopIdsArr);
        }

        $result = [];
        foreach ($foods as $item) {
            $arr = $this->serializeItem($item);
            array_push($result, $arr);
        }
        return $result;
    }

    public function serializeItem(Food $food): array
    {
        $getWebp = function ($webpUrl) {
            ImgOpt::widget(["src" => $webpUrl]);
            return preg_replace('/(?:jpg|jpeg|png|gif)$/i', 'webp', $webpUrl);
        };

        return [
            'id' => $food->id,
            'shop' => [
                'id' => $food->shop_id,
                'title' => $food->shop->title,
            ],
            'title' => $food->title,
            'price' => $food->price,
            'photo' => [
                'src' => $food->photo ? $food->getThumbFileUrl('photo', 'thumb') : "",
                'srcset' => $food->photo ? $getWebp($food->getThumbFileUrl('photo', 'thumb')) : "",
            ],
        ];
    }
}