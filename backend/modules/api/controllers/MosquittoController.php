<?php

namespace backend\modules\api\controllers;
use PhpMqtt\Client\MqttClient;
use yii\base\Controller;

class MosquittoController extends Controller
{
    public function actionSendConsulta()
    {
        $utente = new MqttClient('127.0.0.1',1883,'utenteId');
        $utente -> connect(null,true);

        $utente->subscribe("marcarConsulta", function (string $topic, string $message, bool $retained) use ($utente) {
            $utente->interrupt();
        }, MqttClient::QOS_EXACTLY_ONCE);
        $utente->loop(true);
        $utente->publish("marcarConsulta", 'A consulta foi marcada', 1);
    }


    public function actionSendservicocarrinho()
    {
        $utente = new MqttClient('127.0.0.1',1883,'utenteId');
        $utente -> connect(null,true);

        $utente->subscribe("adicionarservicoCarrinho", function (string $topic, string $message, bool $retained) use ($utente) {
            $utente->interrupt();
        }, MqttClient::QOS_EXACTLY_ONCE);
        $utente->loop(true);
        $utente->publish("adicionarservicoCarrinho", 'O Serviço foi adicionado ao Carrinho', 1);
    }

    public function actionSendprodutocarrinho()
    {
        $utente = new MqttClient('127.0.0.1',1883,'utenteId');
        $utente -> connect(null,true);

        $utente->subscribe("adicionarprodutoCarrinho", function (string $topic, string $message, bool $retained) use ($utente) {
            $utente->interrupt();
        }, MqttClient::QOS_EXACTLY_ONCE);
        $utente->loop(true);
        $utente->publish("adicionarprodutoCarrinho", 'O Produto foi adicionado ao carrinho', 1);
    }

    public function actionDeleteprodutocarrinho()
    {
        $utente = new MqttClient('127.0.0.1',1883,'utenteId');
        $utente -> connect(null,true);

        $utente->subscribe("deleteprodutoCarrinho", function (string $topic, string $message, bool $retained) use ($utente) {
            $utente->interrupt();
        }, MqttClient::QOS_EXACTLY_ONCE);
        $utente->loop(true);
        $utente->publish("deleteprodutoCarrinho", 'O Produto foi removido do carrinho', 1);
    }


    public function actionDeleteservicocarrinho()
    {
        $utente = new MqttClient('127.0.0.1',1883,'utenteId');
        $utente -> connect(null,true);

        $utente->subscribe("deleteservicoCarrinho", function (string $topic, string $message, bool $retained) use ($utente) {
            $utente->interrupt();
        }, MqttClient::QOS_EXACTLY_ONCE);
        $utente->loop(true);
        $utente->publish("deleteservicoCarrinho", 'O Serviço foi removido do carrinho', 1);
    }


    public function actionDeletemarcacao()
    {
        $utente = new MqttClient('127.0.0.1',1883,'utenteId');
        $utente -> connect(null,true);

        $utente->subscribe("deleteMarcacao", function (string $topic, string $message, bool $retained) use ($utente) {
            $utente->interrupt();
        }, MqttClient::QOS_EXACTLY_ONCE);
        $utente->loop(true);
        $utente->publish("deleteMarcacao", 'A marcação foi desmarcada', 1);
    }

}