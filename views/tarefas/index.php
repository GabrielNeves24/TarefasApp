<?php

use app\models\Tarefas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $tarefas */

$this->title = 'Tarefas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarefas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    // Modal para criar nova tarefa
    Modal::begin([
        'title' => '<h4>Criar Tarefa</h4>',
        'toggleButton' => ['label' => 'Criar Tarefa', 'class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px; text-align: center; width: 100%;'],
    ]);

    echo $this->render('_form', [
        'model' => new Tarefas(),
    ]);

    Modal::end();
    ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered ">
            <thead>
                <tr class="text-center">
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Data de Criação</th>
                    <th>Data de Conclusão</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefas->models as $index => $model): ?>
                    <tr>
                        <td><?= Html::encode($model->titulo) ?></td>
                        <td><?= Html::encode($model->descricao) ?></td>
                        <td>
                            <?= $model->dataCriacao ? Html::encode(date('d/m/Y', strtotime($model->dataCriacao))) : '' ?>
                        </td>
                        <td>
                            <?= $model->dataConclusao ? Html::encode(date('d/m/Y', strtotime($model->dataConclusao))) : '' ?>
                        </td>
                        <td>
                            <?php if ($model->estado == 'Pendente'): ?>
                                <span class="badge bg-warning rounded-pill"><?= Html::encode($model->estado) ?></span>
                            <?php elseif ($model->estado == 'Finalizado'): ?>
                                <span class="badge bg-black rounded-pill"><?= Html::encode($model->estado) ?></span>
                            <?php else: ?>
                                <span class="badge bg-success rounded-pill"><?= Html::encode($model->estado) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <?php
                                //Modal para editar
                                Modal::begin([
                                    'title' => '<h4>Editar Tarefa</h4>',
                                    'toggleButton' => ['label' => 'Editar', 'class' => 'btn btn-info'],
                                ]);

                                echo $this->render('_form', [
                                    'model' => $model,
                                ]);

                                Modal::end();
                                ?>
                                <?php
                                //Modal para eliminar
                                Modal::begin([
                                    'title' => '<h4>Confirmar Eliminação</h4>',
                                    'toggleButton' => ['label' => 'Eliminar', 'class' => 'btn btn-danger'],
                                    'footer' => Html::a('Sim', 'javascript:;', [
                                        'class' => 'btn btn-danger delete-task',
                                        'data-id' => $model->id,
                                        'id' =>"delete-task",
                                        'data-url' => Url::to(['tarefas/delete', 'id' => $model->id]), // URL for the delete action
                                    ]) . Html::button('Não', ['class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal']),
                                ]);
                                
                                echo '<p>Tem a certeza que deseja eliminar esta tarefa?</p>';
                                
                                Modal::end();
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$script = <<< JS
$(document).ready(function() {
    $('.delete-task').on('click', function(e) {
        console.log('clicked');
        e.preventDefault();
        var url = $(this).data('url');
        var id = $(this).data('id');
        $.ajax({
            url: url,
            type: 'POST',
            data: { id: id },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Ocorreu ao eleminar tarefa.');
            }
        });
    });
});
JS;
$this->registerJs($script);
?>
