<?php

namespace frontend\controllers\api;

use model\entities\Food\Order;
use model\helpers\ProcessHelper;
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
            'create' => ['POST'],
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
        $email = Yii::$app->request->get('email');
        $phone = Yii::$app->request->get('phone');

        if (empty($email) && empty($phone)) {
            $orders = $this->orders->getAll();
        } else {
            $email = strtolower($email);
            $phone = strtolower($phone);
            $orders = $this->orders->getByEmailOrPhone($email, $phone);
        }

        $result = [];
        foreach ($orders as $item) {
            $arr = $this->serializeItem($item);
            array_push($result, $arr);
        }
        return $result;
    }

    public function actionCreate()
    {
        $request = Yii::$app->request->getRawBody();
        $requestData = json_decode($request);

        $name = $requestData->name;
        $email = strtolower($requestData->email);
        $phone = $requestData->phone;
        $adress = $requestData->adress;
        $products = $requestData->products;

        $form = new OrderForm($name, $email, $phone, $adress, $products);
        if ($form->validate()) {
           try {
               $this->service->create($form);
               Yii::$app->getResponse()->setStatusCode(201);
               return json_encode(['status' =>'OK']);
           } catch (\DomainException $e) {
               throw new BadRequestHttpException($e->getMessage(), null, $e);
           }
        }
    }

    public function serializeItem(Order $order): array
    {
        return [
            'id' => $order->id,
            'client_name' => $order->client_name,
            'email' => $order->email,
            'phone' => $order->phone,
            'adress' => $order->adress,
            'products' => Json::decode($order->products),
            'status' => [
                'id' => $order->status,
                'name' => ProcessHelper::processName($order->status),
             ]
        ];
    }
}