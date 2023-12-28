<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $telefone
 * @property string|null $morada
 * @property string|null $nif
 * @property string|null $codigopostal
 * @property int|null $user_id
 *
 * @property Consultas[] $consultas
 * @property Diagnosticos[] $diagnosticos
 * @property Faturas[] $faturas
 * @property User $user
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['nome'], 'string', 'max' => 45],
            [['telefone', 'nif', 'codigopostal'], 'string', 'max' => 9],
            [['morada'], 'string', 'max' => 25],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'morada' => 'Morada',
            'nif' => 'Nif',
            'codigopostal' => 'Codigopostal',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Consultas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsultas()
    {
        return $this->hasMany(Consultas::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Diagnosticos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiagnosticos()
    {
        return $this->hasMany(Diagnosticos::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Faturas::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
