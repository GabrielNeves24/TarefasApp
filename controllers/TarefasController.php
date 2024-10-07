<?php

namespace app\controllers;

use app\models\Tarefas;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yii;

class TarefasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        
                    ],
                ],
                'access' => [
                    'class' => \yii\filters\AccessControl::className(),
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // Apenas para Users autenticados
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Tarefas models.
     *
     * @return string
     */
    public function actionIndex()
    {  
              
        $tarefas = new ActiveDataProvider([
            'query' => Tarefas::find(),
        ]);
        return $this->render('index', [
            'tarefas' => $tarefas
        ]);
    }
    
    public function actionDelete($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $model = $this->findModel($id);
            if ($model && $model->delete()) {
                return ['success' => true];
            }
        }

        return ['success' => false, 'message' => 'Erro ao eleminar.'];
    }

    public function actionCreate()
    {
        $model = new Tarefas();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true];
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Tarefa atualizada com sucesso!');
                return $this->redirect(['index']);
            }
        }
    }

    

    /**
     * Finds the Tarefas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tarefas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tarefas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Pagina não existe');
    }
}
