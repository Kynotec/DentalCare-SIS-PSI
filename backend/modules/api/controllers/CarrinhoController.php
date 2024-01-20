<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Carbon\Carbon;

use common\models\Carrinho;
use common\models\Carrinhos;
use common\models\Linha_carrinhos;


use common\models\Produtos;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii;
use yii\web\BadRequestHttpException;

class CarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinhos';


    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionBuscarcarrinho($user_id)
    {
        $carrinho = Carrinhos::find()->where(['user_id' => $user_id])->one();

        if ($carrinho) {
            // Busca as linhas do carrinho
            $linhasCarrinho = Linha_carrinhos::find()->where(['carrinho_id' => $carrinho->id])->all();

            // Aqui você pode retornar as informações encontradas, ajuste conforme necessário
            return [
                'carrinho' => $carrinho,
                'linhasCarrinho' => $linhasCarrinho,
            ];
        }

        // Retorna algo indicando que o carrinho não foi encontrado
        return [
            'error' => 'Carrinho não encontrado para o usuário ID ' . $user_id,
        ];
    }



    public function actionAdicionar($produto_id, $user_id)
    {
        $request = \Yii::$app->request;
        $quantidade = $request->getBodyParam('quantidade');


        $carrinho = Carrinhos::find()->where(['user_id' => $user_id])->one();

        if (!$carrinho) {
            $carrinho = new Carrinhos();
            $carrinho->user_id = $user_id;
            $carrinho->data = Carbon::now();
            $carrinho->save();
        }

        $linhaCarrinho = Linha_carrinhos::find()
            ->where(['carrinho_id' => $carrinho->id, 'produto_id' => $produto_id])
            ->one();

        $produto = Produtos::find()->where(['id' => $produto_id])->one();

        if ($linhaCarrinho) {
            $linhaCarrinho->quantidade += $quantidade;
            $linhaCarrinho->recalcularIva();
            $linhaCarrinho->valortotal = $linhaCarrinho->calcularTotal();
        } else {
            $linhaCarrinho = new Linha_carrinhos();
            $linhaCarrinho->carrinho_id = $carrinho->id;
            $linhaCarrinho->quantidade = $quantidade;
            $linhaCarrinho->produto_id = $produto->id;
            $linhaCarrinho->valorunitario = $produto->precounitario;
            $linhaCarrinho->valoriva = $produto->calcularIva();
            $linhaCarrinho->valortotal = $linhaCarrinho->calcularTotal();
        }
        $linhaCarrinho->save();

        return [

        ];

    }







    public function actionCriarPedido()
    {
        try {
            // Verifica se o carrinho está vazio
            $carrinho = Carrinho::find()
                ->where(['user_id' => Yii::$app->params['id'], 'pedido_id' => null])
                ->one();

            if (!$carrinho) {
                throw new Exception("Carrinho vazio");
            }

            // Cria um novo pedido
            $pedido = new Pedido();
            $pedido->user_id = Yii::$app->params['id'];
            $pedido->valortotal = $carrinho->getValorTotal();  // Método a ser implementado no modelo Carrinho

            // Salva o pedido
            if (!$pedido->save()) {
                throw new Exception("Erro ao criar o pedido");
            }

            // Atualiza as linhas do carrinho com o ID do pedido
            LinhaCarrinho::updateAll(['pedido_id' => $pedido->id], ['carrinho_id' => $carrinho->id]);

            return ["response" => "Pedido criado com sucesso"];
        } catch (Exception $e) {
            return ["response" => $e->getMessage()];
        }
    }


    public function actionDatacarrinho($user_id)
    {
        $carrinhomodel = new $this->modelClass;

        $carrinho = $carrinhomodel::find()
            ->where(['user_id' => $user_id])
            ->all();
        return $carrinho;
    }


}
