<?php

namespace backend\controllers;

use backend\models\Db;
use backend\models\Field;
use backend\models\Junction;
use backend\models\Val;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use backend\models\Table;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;

/**
 * TableController implements the CRUD actions for Table model.
 *
 * @property Db $db
 */
class TableController extends CommonController
{
    /**
     * @return Db
     */
    public function getDb(){
        return Db::findOne($this->session->get('db'));
    }

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
        if($db = @$this->getDb()->id){
            $dataProvider = new ActiveDataProvider([
                'query' => Table::find()->where(['id_db' => $db]),
                'sort' => [
                    'defaultOrder' => [
                        'sort' => SORT_ASC,
                    ]
                ],
            ]);
            $dataProvider->pagination->pageSize=100;
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }else{
            $this->session->setFlash('warning', Yii::t('app', 'Check db at first'));
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
                    'sort', 'id', 'name', 'title', 'type.name'
                ],
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                ]
            ],
        ]);
        $fieldDataProvider->pagination->pageSize=100;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'fieldDataProvider' => $fieldDataProvider,
        ]);
    }

    /*public function actionFill($id)
    {
    	$fields = Field::find()->select('id')->where(['id_table' => $id])->all();
        $valDataProvider = new ActiveDataProvider([
            'query' => Val::find()->where(['field_id' => $fields]),
        ]);
        $valDataProvider->pagination->pageSize=100;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'valDataProvider' => $valDataProvider,
        ]);
    }*/

    public function actionAddJunction()
    {
        $model = new Table();
        $model->id_db = $this->db->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Table model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Table();
        $model->id_db = $this->db->id;
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
            return $this->redirect(Yii::$app->request->referrer);
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
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }

    /**
     * @param string $ns
     */
    public function actionGen($ns = 'app')
    {
        print '<pre>';
        print 'git clone https://github.com/mixartemev/yii2-app-advanced.git ' . $this->getDb()->name . "\r\n";
        print 'cd ' . $this->getDb()->name . "\r\n";
        print 'composer install' . "\r\n";
        print 'php init --env=Development --overwrite=All' . "\r\n";
        print 'sed -i "" "s/yii2advanced/'.$this->getDb()->name.'/g" "common/config/main-local.php"' . "\r\n";
        print '#create db if it\'s not and setup login and password for db connection in main-local config' . "\r\n";
        print 'php yii migrate --interactive=0' . "\r\n";

#set db ssettings'."\r\n";
        /** @var Table $table */
        foreach (Table::find()->where(['id_db' => $this->getDb()->id])->orderBy('sort')->all() as $table){
            $fields = [];
            /** @var Field $field */
            if($flds = $table->fields){
                foreach ($flds as $field){
                    $fields []= $field->name
                                . ':' . $field->type->name
                                . ($field->null ? '' : ':notNull')
                                . ($field->unique ? ':unique' : '')
                                . (!$field->signed && in_array($field->id_type, [1, 2]) ? ':unsigned' : '')
                                . ($field->fk ? ':foreignKey('.$field->fkTable->name.')' : '')
                                . ($field->title ? ':comment(\''.$field->title.'\')' : '');
                }
            }else{
                $fields []= 'name:string(255):notNull:unique:comment(\'Название\')';
            }

            print 'php yii mig/create create_'.$table->name.'_table -f="id:primaryKey:notNull:unsigned,'.
                  implode(',', $fields) . '" -c="'.$table->title.'" --interactive=0'."\r\n";
        }

	    foreach (Junction::find()/*->where(['t1' => [$thisDbTables]])*/->all() as $table){
		    print 'php yii mig/create create_junction_table_for_'.$table->t10->name.'_and_'.$table->t20->name.'_tables --interactive=0'."\r\n";
	    }

	    print 'php yii mig --interactive=0' . "\r\n";
	    print 'php yii gii/mod --tableName=* --ns='.$ns.'\models --generateLabelsFromComments=1 --overwrite=1  --interactive=0' . "\r\n";

        foreach (Table::find()->where(['id_db' => $this->getDb()->id, 'gen_crud' => 1])->all() as $table){
            $class = Inflector::camelize($table->name);
            print 'php yii gii/construct --modelClass="'.$ns.'\models\\'.$class.'" --interactive=0 --enablePjax --enableI18N --controllerClass="'.
                  $ns.'\controllers\\'.$class.'Controller" --overwrite=1 --viewPath=@'.$ns.'/views/'.$table->name."\r\n";
        }
        print '</pre>';
    }
}
