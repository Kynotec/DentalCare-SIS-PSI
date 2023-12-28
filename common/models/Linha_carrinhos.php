<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linha_carrinhos".
 *
 * @property int $id
 * @property float|null $quantidade
 * @property float|null $valorunitario
 * @property float|null $valoriva
 * @property float|null $valortotal
 * @property int|null $carrinho_id
 * @property int $produto_id
 *
 * @property Carrinhos $carrinho
 * @property Produtos $produto
 */
class Linha_carrinhos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linha_carrinhos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'valorunitario', 'valoriva', 'valortotal'], 'number'],
            [['carrinho_id', 'produto_id'], 'integer'],
            [['produto_id'], 'required'],
            [['carrinho_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinhos::class, 'targetAttribute' => ['carrinho_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produtos::class, 'targetAttribute' => ['produto_id' => 'id']],
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
            'carrinho_id' => 'Carrinho ID',
            'produto_id' => 'Produto ID',
        ];
    }

    /**
     * Gets query for [[Carrinho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinhos::class, ['id' => 'carrinho_id']);
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
}
