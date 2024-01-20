<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property int|null $ativo
 * @property string $nome
 * @property string|null $descricao
 * @property float|null $precounitario
 * @property int|null $stock
 * @property int|null $iva_id
 * @property int|null $categoria_id
 *
 * @property Categorias $categoria
 * @property Imagens[] $imagens
 * @property Iva $iva
 * @property Linha_Carrinhos[] $linhaCarrinhos
 * @property Linha_Faturas[] $linhaFaturas
 */
class Produtos extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;



    public function getStatusLabel()
    {
        switch ($this->ativo)
        {
            case self::STATUS_ACTIVE:
                return '<span class="badge badge-success">Ativo</span>';

            case self::STATUS_INACTIVE:
                return '<span class="badge badge-danger">Desativado</span>';

            default:
                return '<span class="badge badge-info">' . $this->ativo . '</span>';
        }
    }


    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stock', 'iva_id', 'categoria_id'], 'integer'],
            [['nome'], 'required'],
            [['nome','iva_id','categoria_id','descricao','precounitario','stock'], 'required'],
            [['descricao'], 'string'],
            [['precounitario'], 'number'],
            [['nome'], 'string', 'max' => 250],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['iva_id' => 'id']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            ['ativo', 'default', 'value' => self::STATUS_ACTIVE],
            ['ativo', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',

            'filename' =>'Imagem do Produto',
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'precounitario' => 'Preço unitario',
            'stock' => 'Stock',
            'iva_id' => 'Iva',
            'categoria_id' => 'Categoria',
            'ativo' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Imagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagens()
    {
        return $this->hasMany(Imagem::class, ['produto_id' => 'id']);
    }
    public function getShortDescription()
    {
        return \yii\helpers\StringHelper::truncateWords(strip_tags($this->descricao), 20);
    }

    /**
     * Gets query for [[Iva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Iva::class, ['id' => 'iva_id']);
    }

    public function calcularIva()
    {
        if ($this->iva) {
            return $this->precounitario * ($this->iva->percentagem / 100);
        }
        return 0;
    }

    /**
     * Gets query for [[LinhaCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaCarrinhos()
    {
        return $this->hasMany(LinhaCarrinho::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[LinhaFaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaFaturas()
    {
        return $this->hasMany(LinhaFatura::class, ['produto_id' => 'id']);
    }
}
