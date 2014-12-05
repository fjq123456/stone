<?php
use yii\helpers\Url;
use common\widgets\EForm;
?>

<!--引入CSS-->
<link rel="stylesheet" type="text/css" href="static/common/webuploader/webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="static/common/webuploader/webuploader.js"></script>

<!--dom结构部分-->
<div id="uploader-demo">
    <!--用来存放item-->
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">选择图片</div>
</div>

<div class="urls hidden">
    <a href="<?=Url::toRoute('/upload/web-upload');?>" class="web-upload"></a>
</div>
<script>

    var url = $('.web-upload').attr('href');
    var csrf = $('meta[name=csrf-token]').attr('content');
    // 初始化Web Uploader
    var uploader = WebUploader.create({
        fileVal : 'GoodsBrand[logo]',
        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: '/static/common/webuploader/Uploader.swf',

        // 文件接收服务端。
        server: url,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',
        formData:{
            '_csrf' : csrf,
            'res_name' : 'article'
//            'db' : true
        },
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

</script>