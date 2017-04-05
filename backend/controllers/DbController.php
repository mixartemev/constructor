<?php

namespace backend\controllers;

use backend\models\Field;
use backend\models\Table;
use Yii;
use backend\models\Db;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DbController implements the CRUD actions for Db model.
 */
class DbController extends CommonController
{
    const TYPE_INT = 1;
    const TYPE_sINT = 2;
    const TYPE_STR = 3;
    const TYPE_TXT = 4;
    const TYPE_BOOL = 5;
    const TYPE_DATE = 6;
    const TYPE_DATETIME = 7;
    const TYPE_DEC31 = 8;
    const TYPE_DEC72 = 9;
    const TYPE_DEC132 = 10;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Db models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Db::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Db model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Db model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Db();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /*public function actionImport($db_name, $user, $password = '', $host = '127.0.0.1')
    {
        Yii::$app->setComponents(['db0' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host=$host;dbname=$db_name",
            'username' => $user,
            'password' => $password,
            'charset' => 'utf8',
        ]]);

        $db0 = Yii::$app->db0;

        $model = new Db();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * @param $array
     * @return \yii\web\Response
     */
    public function actionLoad($array = [])
    {
        $array = [
            'object_cms' => [
                0,
                'metro' => [
                    ['name', self::TYPE_STR]
                ],
                'complex' => [
                    ['name', self::TYPE_STR],
                    ['metro_id', self::TYPE_INT, 1],
                    ['address', self::TYPE_STR],
                    ['exploit_apartment_cost', self::TYPE_DEC72],
                    ['exploit_office_cost', self::TYPE_DEC72],
                    ['exploit_torg_cost', self::TYPE_DEC72],
                    ['description', self::TYPE_STR],
                ],
                'tower' => [
                    ['name', self::TYPE_STR],
                    ['complex_id', self::TYPE_INT, 2],
                    ['square', self::TYPE_INT],
                    ['floor', self::TYPE_sINT],
                    ['ceiling', self::TYPE_DEC31],
                ],
                'object' => [
                    ['name', self::TYPE_STR],
                    ['tower_id', self::TYPE_INT, 3],
                    ['square', self::TYPE_INT],
                    ['floor', self::TYPE_sINT],
                    ['ceiling', self::TYPE_DEC31],
                    ['created_at', self::TYPE_INT],
                    ['updated_at', self::TYPE_INT],
                ],
            ],
        ];

        foreach($array as $dbName => $tables){
            $db = new Db(['name' => $dbName, 'user_id' => Yii::$app->user->id]);
            if($db->save()){
                $t_i = 0;
                $t_map = [];
                foreach($tables as $table_name => $fields){
                    if($table_name){
                        $table = new Table(['name' => $table_name, 'sort' => $t_i, 'id_db' => $db->id]);
                        if($table->save()){
                            $t_map[$t_i] = $table->id;
                            foreach($fields as $f_i => $prop){
                                $field = new Field([
                                    'name' => $prop[0],
                                    'id_type' => $prop[1],
                                    'sort' => $f_i,
                                    'id_table' => $table->id,
                                    'null' => isset($prop[3]),
                                    'signed' => isset($prop[4])
                                ]);
                                if(isset($prop[2])){
                                    $field->fk = $t_map[$prop[2]];
                                }
                                if(!$field->save()){
                                    $this->session->setFlash('error', "Field {$prop[0]} not created");
                                    break;
                                }
                            }
                        }
                        else{
                            $this->session->setFlash('error', "Table $table_name not created");
                            break;
                        }
                    }
                    $t_i++;
                }
            }
            else{
                $this->session->setFlash('error', "Db $dbName not created");
                break;
            }
        }

        return $this->redirect('/db');

    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionCheck($id)
    {
        $this->session->set('db', $id);
        $this->session->setFlash('success', "DataBase selected");
        return $this->redirect('/table');
    }

    /**
     * Updates an existing Db model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Db model.
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
     * Finds the Db model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Db the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Db::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }
}
