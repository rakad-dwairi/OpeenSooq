<?php

namespace frontend\controllers;


use frontend\resource\Comment;
use frontend\resource\Post;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;


class ActiveController extends \yii\rest\ActiveController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['only'] = ['create', 'update', 'delete'];
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];

        return $behaviors;
    }


    public function checkAccess($action, $model = null, $params = [])
    {
        if (in_array($action, ['update', 'delete']) && $model->created_by !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException("You do not have permission to change this record");
        }
    }
}
