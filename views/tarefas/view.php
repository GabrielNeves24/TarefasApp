<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tarefas $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tarefas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tarefas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titulo',
            'descricao',
            'dataCriacao',
            'dataConclusao',
            'estado',
        ],
    ]) ?>

</div>
