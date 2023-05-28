<?php

namespace frontend\controllers\api;

use DomainException;
use model\entities\Food\Order;
use model\forms\manage\Food\OrderForm;
use model\readModels\Food\OrderReadRepository;
use model\services\manage\Food\OrderManageService;
use Yii;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class OrderController extends Controller
{
    private $orders;
    private $service;

    public function __construct(
        $id,
        $module,
        OrderManageService $service,
        OrderReadRepository $orders,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->orders = $orders;
    }

    protected function verbs(): array
    {
        return [
            'index' => ['POST'],
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
        $request = Yii::$app->request->getRawBody();
        $requestData = json_decode($request);




        $name = $requestData->name;
        $email = $requestData->email;
        $phone = $requestData->phone;
        $adress = $requestData->adress;
        $products = $requestData->products;

       try {
           $form = new OrderForm($name, $email, $phone, $adress, $products);
           if ($form->validate()) {
               try {
                   $order = $this->service->create($form);
               } catch (DomainException $e) {
                   Yii::$app->errorHandler->logException($e);
               }
           }

           return $requestData;

       } catch (\DomainException $e) {
           throw new BadRequestHttpException($e->getMessage(), null, $e);
       }

    }


}