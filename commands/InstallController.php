<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

/**
 * Установочный контроллер приложения
 */
class InstallController extends Controller
{

    public function actionIndex()
    {
        // запускаем миграции
        Yii::$app->runAction('migrate', ['migrationPath' => '@app/migrations/', 'interactive' => false]);
        Yii::$app->runAction('migrate', ['migrationPath' => '@vendor/costa-rico/yii2-images/migrations/', 'interactive' => false]);
        // создаем админа если нет
        if(!User::find()->where(['username' => 'admin'])->exists())
        {
            $user = Yii::createObject([
                'class' => User::class,
                'scenario' => 'create',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'status' => User::STATUS_ADMIN,
                'password' => 'mysecret',
            ]);
            if (!$user->insert(false)) {
                return false;
            }
            // выводи инфу о пользователе
            echo "Создан пользователь для входа в административную часть сайта\n" .
                "Логин: admin\nПароль: mysecret";
        }
        // создаем модератора если нет
        if (!User::find()->where(['username' => 'moderator'])->exists()) {
            $user = Yii::createObject([
                'class' => User::class,
                'scenario' => 'create',
                'email' => 'moderator@example.com',
                'username' => 'moderator',
                'status' => User::STATUS_MODER,
                'password' => 'supersecret',
            ]);
            if (!$user->insert(false)) {
                return false;
            }
            // выводи инфу о пользователе
            echo "Создан пользователь для модерации\n" .
                "Логин: moderator\nПароль: supersecret";
        }

        return ExitCode::OK;
    }
}
