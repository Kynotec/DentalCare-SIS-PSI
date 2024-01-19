<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;
class ServicoController extends ActiveController
{
    public $modelClass = 'common\models\Servicos';


    //Permite ir buscar o valor da percentagem do iva_id associado
    public function actionGetIva()
    {
        $model = new $this->modelClass;

        $servicos = $model::find()
            ->select([
                'servicos.id',
                'servicos.referencia',
                'servicos.nome',
                'servicos.descricao',
                'servicos.preco',
                'servicos.ativo',
                'servicos.iva_id',
                '(SELECT percentagem FROM ivas WHERE id = servicos.iva_id) AS ivaspercentagem'
            ])
            ->asArray()
            ->all();

        return $servicos;
    }

    public function actionServicospeladescricao($descricao)
    {
        $servicomodel = new $this->modelClass;
        $servico = $servicomodel::find()
            ->where(['descricao' => $descricao])
            ->all();
        return $servico;
    }

}
