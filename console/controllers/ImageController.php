<?php
/**
 * 图片处理
 * User: zhangbo
 * Date: 2015/4/24
 * Time: 10:25
 */
namespace console\controllers;

use Yii;
use yii\console\Controller;
class ImageController extends Controller{
    public function actionBatchCompress(){
        //echo Yii::$app->basePath;exit;
        foreach(glob(Yii::$app->basePath.'/../backend/web/uploads/*') as $img){
            $path = pathinfo($img);
            $size = 360;
            $picPath = $path['dirname'].'/'.$path['filename'].'_'.$size.'.'.$path['extension'];
            if(strpos($img, '_'.$size) > 0){
                continue;
            }

            //图片压缩
            $img = new \Imagick($img);
            $img->thumbnailImage($size, 0);
            $img->writeImage($picPath);
            echo $picPath."\n";
        }
    }
}