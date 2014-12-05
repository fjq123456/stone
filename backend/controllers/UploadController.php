<?php
/**
 * 
 * ylwkj.com
 * ============================================================================
 * 版权所有: 云力维科技有限公司。
 * 网站地址: http://www.ylwkj.com/
 * ----------------------------------------------------------------------------
 * 许可声明：未经许可不得将本软件的整体或任何部分用于商业用途及再发布。
 * ============================================================================
 * Author: wsq(wansq@ylwkj.com)
 * Date: 14-12-3 下午10:11
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\Upload;
use common\models\Attachment;
use common\models\GoodsBrand;
class UploadController extends Controller{

    public function actionWebUpload()
    {

        $model = new GoodsBrand();
        $upload = Upload::getInstance($model, 'logo');
        $res_name = Yii::$app->request->post('res_name');
        $db = Yii::$app->request->post('db');
        if ($db) {
            $img = new Attachment;
            $img->setInfo($upload, $res_name)->save();
            return $img->id;
        } else {
            return $upload->save($res_name);
        }
    }
} 