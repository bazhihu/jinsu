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
        foreach(glob(Yii::$app->basePath.'/../backend/web/uploads/*') as $img){
            $path = pathinfo($img);

            if(strpos($img, '_360') > 0 || strpos($img, '_120') > 0 || strpos($img, '_240') > 0){
                continue;
            }

            //图片压缩
            $im = new \Imagick($img);
            $picPath = $path['dirname'].'/'.$path['filename'].'_120.'.$path['extension'];
            $im->thumbnailImage(120, 0);
            $im->writeImage($picPath);

            $im = new \Imagick($img);
            $picPath = $path['dirname'].'/'.$path['filename'].'_240.'.$path['extension'];
            $im->thumbnailImage(240, 0);
            $im->writeImage($picPath);

            $im = new \Imagick($img);
            $picPath = $path['dirname'].'/'.$path['filename'].'_360.'.$path['extension'];
            $im->thumbnailImage(360, 0);
            $im->writeImage($picPath);


            echo $picPath."\n";
        }
    }
}