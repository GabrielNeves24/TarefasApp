<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="tarefas-form">

    <?php $form = ActiveForm::begin([
        'id' => 'tarefas-form',       
        'action' => $model->isNewRecord ? ['tarefas/create'] : ['tarefas/update', 'id' => $model->id],
        
    ]); ?>

    
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'estado')->dropDownList(['Pendente' => 'Pendente', 'Finalizado' => 'Finalizado', 'Em Curso' => 'Em Curso']) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'dataCriacao')->input('date') ?>

    <?= $form->field($model, 'dataConclusao')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php 
$script = <<< JS
$('form#tarefas-form').on('beforeSubmit', function(e) {
    e.preventDefault(); 
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(result) {
            console.log(result);
            if (result.success) {
                location.reload();
            }
        },
        error: function(xhr, status, error) {
            alert('Erro ao guardar a tarefa.');
        }
    });
    return false;
});
JS;
$this->registerJs($script);
?>
