<?php

namespace backend\modules\menu\models;

use Yii;
use common\helpers\Files;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property string $app_name
 * @property string $auth_name
 * @property integer $pid
 * @property string $module_name
 * @property string $controller_name
 * @property string $action_name
 * @property string $icon
 * @property integer $sort
 * @property integer $created_at
 * @property integer $status
 */
class Menu extends ActiveRecord
{


    const STATUS_ACTIVE = 1;
    public $appModule;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{menu}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @title 按权限取菜单列表
     */
    public function getRoleMenus()
    {

    }

    /**
     * @title 取出所有菜单列表
     */
    public static function getMenus()
    {
        $menus = self::find()
                    ->where(['status' => self::STATUS_ACTIVE])
                    ->orderBy('sort')
                    ->asArray()
                    ->all();
        $unallowed_permissions = self::unallowed();
        if ($unallowed_permissions) {
            foreach ($menus as $k => $v) {
                if (in_array($v['auth_name'], $unallowed_permissions)) {
                    unset($menus[$k]);
                }
            }
        }
        $menus = recursion($menus,0,1);
        return $menus;
    }

    public static function unallowed()
    {
        $user_id = Yii::$app->user->id;
        if ($user_id==1) {
            return false;
        }
        $auth = Yii::$app->authManager;
        $all_permissions  = array_keys($auth->getPermissions());
        $user_permissions = array_keys($auth->getPermissionsByUser($user_id));
        $unallowed_permissions = array_diff($all_permissions, $user_permissions);
        return $unallowed_permissions;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pid'], 'integer'],
            [['name', 'app_name'], 'string', 'max' => 255],
            [['auth_name'], 'string', 'max' => 100],
            [['app_name', 'module_name', 'controller_name', 'action_name'], 'string', 'max' => 200],
            [['icon'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名',
            'app_name' => '项目名',
            'auth_name' => '权限',
            'pid' => '父ID',
            'module_name' => 'module',
            'controller_name' => '控制器',
            'action_name' => '方法',
            'icon' => '图标',
            'sort' => '排序',
            'created_at' => '创建时间',
            'status' => '状态',
        ];
    }

    public function getApps()
    {
        $methods = self::getMenuFromFile();
        $menu = self::keyValue(array_keys($methods));
        array_unshift($menu, '无');
        return $menu;
    }

    public static function getControllers($app_name='')
    {
        if (empty($app_name)) {
            return [];
        }
        $methods = self::getMenuFromFile();
        return self::keyValue(array_keys($methods[$app_name]));
    }

    public static function getActions($app_module_name='')
    {
        if (empty($app_module_name)) {
            return [];
        }
        $methods = self::getMenuFromFile();
        $arr = explode('_', $app_module_name);
        if (!isset($methods[$arr[0]][$arr[1]])) {
            return [];
        }
        $meth = $methods[$arr[0]][$arr[1]];
        foreach ($meth as $k => &$v) {
            $meth[$k] = $k.' '.$v['des'];
        }
        return $meth;

    }


    public static function keyValue($arr)
    {
        $new_arr = [];
        foreach ($arr as $k => $v) {
            $new_arr[$v] = $v;
        }
        return $new_arr;
    }

    public static function getMenuFromFile()
    {
        $methods = self::getFileMethods();
        $menus = [];
        foreach ($methods as $key => $val) {
            $name = str_replace('/', '_', str_replace('/modules/', '@', $key));
            $name = strtolower($name);
            $arr = explode('_', $name);

            foreach ($val as $k => $v) {
                $menus[$arr[0]][$arr[1]][$k] = [
                    'auth' => $name.'_'.$k,
                    'des'  => $v
                ];
            }
        }
        return $menus;
    }

    public static function getFileMethods()
    {
        $module = \Yii::$app->controller->module;

        //在配置中添加的要接受控制的命名空间
        $namespaces = $module->params['menuPath'];

        //不要接受控制的 module
        $sys_module = ['debug', 'gii'];

        $modules = Yii::$app->getModules();
        foreach ($modules as $k => $v) {
            if (in_array($k, $sys_module)) {
                continue;
            }
            $mod = Yii::$app->getModule($k);
            $namespace = str_replace('/', '\\', $mod->controllerNamespace);
            array_push($namespaces, $namespace);
        }

        //当前所在命名空间的控制器
        $currentNamespace = str_replace('/', '\\', \Yii::$app->controllerNamespace);
        array_push($namespaces, $currentNamespace);

        //获取类方法
        $actions = Files::getAllMethods($namespaces);
        return $actions;
    }

    public function getMenu($is_select=true)
    {
        $menus = self::find()
                    ->where(['status' => self::STATUS_ACTIVE])
                    ->asArray()
                    ->all();
        

        $menus = recursion($menus,0,2);
        $arr = [0 => '顶级'];
        foreach ($menus as $k => $v) {
            $arr[$v['id']] = $v['html'] . $v['name'];
        }
        if ($is_select != true) {
            return $menus;
        } else {
            
            return $arr;
        }
    }


    /**
     * @title 保存前，先整理数据
     */
    public function beforeValidate()
    {
        if (!empty($this->app_name)) {
            $this->auth_name = $this->app_name . 
                '-' . $this->controller_name.
                '-'.$this->action_name;
        }
        if (strpos($this->app_name, '@')) {

            $arr = explode('@', $this->app_name);
            $this->app_name = array_shift($arr);
            $this->module_name = array_shift($arr);
        }
        $this->status = self::STATUS_ACTIVE;
        
        return true;
    }
    
}
