<?php

namespace backend\controllers;

use backend\models\Field;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use backend\models\Table;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * TableController implements the CRUD actions for Table model.
 */
class TableController extends CommonController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => Table::className(),
            ],
        ];
    }

    /**
     * Lists all Table models.
     * @return mixed
     */
    public function actionIndex()
    {
        if($db = $this->session->get('db')){
            $dataProvider = new ActiveDataProvider([
                'query' => Table::find()->where(['id_db' => $db]),
                'sort' => [
                    'defaultOrder' => [
                        'sort' => SORT_ASC,
                    ]
                ],
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }else{
            $this->session->setFlash('warning', 'Check db at first');
            return $this->redirect('/db');
        }
    }

    /**
     * Displays a single Table model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $fieldDataProvider = new ActiveDataProvider([
            'query' => Field::find()->where(['id_table' => $id])->joinWith('type'),
            'sort' => [
                'attributes' => [
                    'sort','id','name','type.name'
                ],
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'fieldDataProvider' => $fieldDataProvider,
        ]);
    }

    /**
     * Creates a new Table model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Table();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Table model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Table model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Table model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Table the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Table::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $ns
     */
    public function actionGen($ns)
    {
        /** @var Table $table */
        foreach (Table::find()->where(['id_db' => $this->session->get('db')])->orderBy('sort')->all() as $table){
            $fields = [];
            /** @var Field $field */
            foreach ($table->fields as $field){
                $fields []= $field->name
                    . ':' . $field->type->name . ($field->null ? '' : ':notNull')
                    . (!$field->signed && in_array($field->id_type, [1, 2]) ? ':unsigned' : '')
                    . ($field->fk ? ':foreignKey('.$field->fkTable->name.')' : '');
            }
            print 'php yii migrate/create create_'.$table->name.'_table --fields="'. implode(',', $fields) . '" --interactive=0'."\r\n";
        }
        print 'php yii gii/model --tableName=* --ns="'.$ns.'\models" --interactive=0'."\r\n";
        foreach (Table::find()->where(['id_db' => $this->session->get('db'), 'gen_crud' => 1])->all() as $table){
            $class = ucfirst($table->name);
            print 'php yii gii/crud --modelClass="'.$ns.'\models\\'.$class.'" --interactive=0 --enablePjax --enableI18N --controllerClass="'.$ns.'\controllers\\'.$class.'Controller" --viewPath=@'.$ns.'/views/'.$table->name."\r\n";
        }
    }
}
