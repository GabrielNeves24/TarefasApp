<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Tarefas".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descricao
 * @property string $dataCriacao
 * @property string|null $dataConclusao
 * @property string $estado
 */
class Tarefas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Tarefas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descricao', 'dataCriacao', 'estado'], 'required'],
            [['descricao'], 'string'],
            [['dataCriacao', 'dataConclusao'], 'safe'],
            [['titulo', 'estado'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'dataCriacao' => 'Data Criacao',
            'dataConclusao' => 'Data Conclusao',
            'estado' => 'Estado',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['id'];
    }



}
