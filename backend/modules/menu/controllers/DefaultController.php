<?php

namespace backend\modules\menu\controllers;

use Yii;
use backend\modules\menu\models\Menu;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * @title MenuController
 */
class DefaultController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @title 菜单列表
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Menu();
        Menu::getMenus();
        // $model->test(1);
        return $this->render('index', [
            'model' => $model,
            'menu'  => $model->getMenu(false)
        ]);
    }

    /**
     * Displays a single Menu model.
     * @title 菜单详情
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
     * @title 添加菜单
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Menu();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * @title 项目名->控制器->方法
     */
    public function actionChild($appname='')
    {
        $data = [];
        if (!strpos($appname, '_')) {
            $controllers = Menu::getControllers($appname);
            $controller = current($controllers);
            $actions = Menu::getActions($appname.'_'.$controller);
            $data = [
                'controller' => $controllers,
                'actions'    => $actions
            ];
        } else {
            $data['actions'] = Menu::getActions($appname);
        }
        $this->ajaxReturn($data, null, 1);
    }

    /**
     * @title 更新菜单
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->app_name .= $model->module_name ? '@'.$model->module_name : '';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @title 删除菜单
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
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
