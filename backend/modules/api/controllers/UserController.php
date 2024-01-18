<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Profiles;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
class UserController extends ActiveController
{

    public $modelClass = 'common\models\Profiles'; // Para ir buscar o modelo a ser usado no controlador

    //METODO DE AUTENTICAÇÃO

    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    // Obter perfil do cliente com o login feito na app mobile
    public function actionGetPerfil()
    {
        $model = new $this->modelClass;

        $perfil = $model::findOne(Yii::$app->params['id']);

        return $perfil;
    }



    public function actionAtualizarPerfil()
    {
        $request=\Yii::$app->request->post();
        $climodel = new $this->modelClass;

        $ret = $climodel::findOne(Yii::$app->params['id']);

        if($ret) {
            $ret->nome = $request['nome'];
            $ret->telefone = $request['telefone'];
            $ret->nif = $request['nif'];
            $ret->codigopostal = $request['codigopostal'];
            $ret->morada = $request['morada'];
            $ret->save();
            return ["success" => true];
        }
        else {

            return ["success" => false];
        }
    }


    public function actionUtentespelonome($nome)
    {
        $usermodel = new $this->modelClass;

        $users = $usermodel::find()
            ->select(['profiles.id', 'nome', 'telefone', 'morada','nif','codigopostal','user.email','user.status'])
            ->innerJoinWith('user')
            ->Where(['nome' => $nome])
            ->asArray()
            ->all();

        return $users;
    }



    // Obter perfil do cliente com o login feito na app mobile
    public function actionGetProfiles()
    {
        $model = new $this->modelClass;

        $profiles = $model::findOne(Yii::$app->params['id']);

        return $profiles;
    }


}
