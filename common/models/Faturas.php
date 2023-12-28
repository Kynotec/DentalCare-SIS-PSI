<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property string|null $data
 * @property float|null $valortotal
 * @property float|null $ivatotal
 * @property float|null $subtotal
 * @property string|null $estado
 * @property int|null $profile_id
 *
 * @property LinhaFaturas[] $linhaFaturas
 * @property Profiles $profile
 */
class Faturas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['valortotal', 'ivatotal', 'subtotal'], 'number'],
            [['profile_id'], 'integer'],
            [['estado'], 'string', 'max' => 30],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'valortotal' => 'Valortotal',
            'ivatotal' => 'Ivatotal',
            'subtotal' => 'Subtotal',
            'estado' => 'Estado',
            'profile_id' => 'Profile ID',
        ];
    }

    /**
     * Gets query for [[LinhaFaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaFaturas()
    {
        return $this->hasMany(LinhaFaturas::class, ['fatura_id' => 'id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::class, ['id' => 'profile_id']);
    }
}
