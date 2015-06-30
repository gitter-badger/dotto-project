<?php
/**
 * Created by PhpStorm.
 * User: thelia
 * Date: 30/06/2015
 * Time: 12:44
 */

namespace WareHouse\Controller;


use Thelia\Controller\Admin\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function dashboardAction()
    {
        //$admin = $this->getRequest()->getSession()->getAdminUser();

        return $this->render("dashboard");
    }

}