<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

class AboutController extends FrontController
{
    public function indexAction()
    {
        return $this->render('FsbAlfredDashboardBundle:Pages/About:index.html.twig');
    }
}
