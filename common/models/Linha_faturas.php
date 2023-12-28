<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linha_faturas".
 *
 * @property int $id
 * @property float|null $quantidade
 * @property float|null $valorunitario
 * @property float|null $valoriva
 * @property float|null $valortotal
 * @property int|null $fatura_id
 * @property int|null $produto_id
 * @property int $servico_id
 *
 * @property Faturas $fatura
 * @property Produtos $produto
 * @property Servicos $servico
 */
class Linha_faturas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linha_faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'valorunitario', 'valoriva', 'valortotal'], 'number'],
            [['fatura_id', 'produto_id', 'servico_id'], 'integer'],
            [['servico_id'], 'required'],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faturas::class, 'targetAttribute' => ['fatura_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produtos::class, 'targetAttribute' => ['produto_id' => 'id']],
            [['servico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicos::class, 'targetAttribute' => ['servico_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantidade' => 'Quantidade',
            'valorunitario' => 'Valorunitario',
            'valoriva' => 'Valoriva',
            'valortotal' => 'Valortotal',
            'fatura_id' => 'Fatura ID',
            'produto_id' => 'Produto ID',
            'servico_id' => 'Servico ID',
        ];
    }

    /**
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFatura()
    {
        return $this->hasOne(Faturas::class, ['id' => 'fatura_id']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produtos::class, ['id' => 'produto_id']);
    }

    /**
     * Gets query for [[Servico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServico()
    {
        return $this->hasOne(Servicos::class, ['id' => 'servico_id']);
    }
}
