<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\queue\amqp_interop\Queue;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\jobs\CreateRequestJob;
use common\jobs\CommentRequestJob;
use yii\rest\ActiveController;
use yii\rest\Serializer;
use common\models\Request as RequestModel;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
    * Комментирование заявки
    */
    public function actionPutRequests()
    {
        return ['result' => !!\Yii::$app->queueComments->push(new CommentRequestJob([
            'id' => Yii::$app->request->getQueryParam('id')
            , 'comment' => Yii::$app->request->getBodyParam('comment'),
        ])),];
    }

    /**
    * Получение некомментированных заявок
    */
    public function actionGetRequests()
    {
        return RequestModel::getActive();
    }

    /**
    * Создание заявки
    */
    public function actionPostRequests()
    {
        $data = Yii::$app->request->post();

        return ['result' => !!\Yii::$app->queueRequests->push(new CreateRequestJob([
            'name' => $data['name']
            , 'email' => $data['email']
            , 'message' => $data['message'],
        ])),];
    }
}
