<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;

class BackendController extends Controller {

    public $layout = 'admin-template';
    public $title;
    public $pageTitle;
    public $menu = array();

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow view user to perform 'view' and 'delete' actions
                'users' => User::getAdmins(),
            ),
            array('deny', // deny all users
                'users' => array("*"),
            ),
        );
    }

}

