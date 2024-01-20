<?php

namespace backend\modules\api\controllers;

use common\models\Profiles;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class AuthController extends ActiveController
{
    public $modelClass = 'common\models\User'; // Para ir buscar o modelo a ser usado no controlador

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] =
            ['class' => HttpBasicAuth::className(),
                'auth' => [$this, 'auth']
            ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            return $user;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication');//403
    }

    // Fazer login na app mobile
    public function actionLogin()
    {
        $username = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
        $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;

        $user = User::findByUsername($username);

        if ($user && $user->validatePassword($password))
        {
            $profiles = Profiles::findOne($user->getId());
            $nome = $profiles->nome;
            $user_id =$user->id;
            $token = $user->auth_key;
            // $token = base64_encode($username.":".$password);
            return ['token' =>$token, 'success' => true, 'username' => $nome,'user_id'=>$user_id];
        }

        return ['success' => false];

    }


}
