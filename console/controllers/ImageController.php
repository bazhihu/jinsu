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
            $img = new \Imagick($img);
            $picPath = $path['dirname'].'/'.$path['filename'].'_120.'.$path['extension'];
            $img->thumbnailImage(120, 0);
            $img->writeImage($picPath);

            $img = new \Imagick($img);
            $picPath = $path['dirname'].'/'.$path['filename'].'_240.'.$path['extension'];
            $img->thumbnailImage(240, 0);
            $img->writeImage($picPath);

            $img = new \Imagick($img);
            $picPath = $path['dirname'].'/'.$path['filename'].'_360.'.$path['extension'];
            $img->thumbnailImage(360, 0);
            $img->writeImage($picPath);


            echo $picPath."\n";
        }
    }
}