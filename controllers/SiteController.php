<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MyForm;
use app\models\Comments;
use yii\data\Pagination;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model

        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionHello($message = 'Hello world!!!')
    {
        return $this->render('hello',
            ['message' => $message]
        );
    }

    public function actionForm()
    {
        $form = new MyForm();

        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $name = Html::encode($form->name);
            $email = Html::encode($form->email);

            $form->file = UploadedFile::getInstance($form,'file');
            $form->file->saveAs('photo/'.$form->file->baseName.'.'.$form->file->extension);
        }

        

        return $this->render('form',
            ['form' => $form]
        );
    }

    public function actionComments()
    {
        $comments = Comments::find();

        $pagination = new Pagination([
            'defaultPageSize' =>3,              //количество записей на странице
            'totalCount' => $comments->count()  //количество страниц

            ]);

        $comments = $comments->offset($pagination->offset)->limit($pagination->limit)->all();

        $cookies = Yii::$app->request->cookies;



        return $this->render('comments',
                [
                'comments' => $comments,
                'pagination' => $pagination,
                'namess' => Yii::$app->session->get('names'),
                'namecc' => $cookies->getValue('namec')
                ]
            );
    }


    public function actionUser()
    {
        $name = Yii::$app->request->get('name', 'user не найден');

        
        $session = Yii::$app->session;
       $cookies = Yii::$app->response->cookies;

        $session->set('names', $name);
       $cookies->add(new \yii\web\Cookie([
            'name' => 'namec',
            'value'=> $name
        ]));

       

            return $this->render('user',
            [
            'namess' => $name,
            'namecc' => $name
            ]
        );        
    }


}
