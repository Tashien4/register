<?php $file = Yii::getAlias(__DIR__.'/../../output/all.zip');

             Yii::$app->response->sendFile($file);   

?>