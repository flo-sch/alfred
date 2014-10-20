<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

class HomeController extends FrontController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $drivenDistance = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getKilometersDifference();
        $averageConsommation = ($drivenDistance > 0 ? (100 * (($em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalCapacity() - $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getLastCapacity()) / $drivenDistance)) : 0);

        $averageGasoilPrice = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getAverageLiterPrice();

        $gasoilTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalAmount();
        $reparationsTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Reparation')->getTotalPrice();
        $highwaysTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Highway')->getTotalPrice();
        $insuranceTotalPrice = $em->getRepository('FsbAlfredCoreBundle:InsuranceFee')->getTotalPrice();
        $averagePrice = ($drivenDistance > 0 ? (($gasoilTotalPrice + $reparationsTotalPrice + $highwaysTotalPrice + $insuranceTotalPrice) / $drivenDistance) : 0);

        return $this->render('FsbAlfredDashboardBundle:Pages/Home:index.html.twig', array(
            'averageConsommation' => $averageConsommation,
            'averageLiterPrice' => $averageGasoilPrice,
            'averageCost' => $averagePrice,
            'gasoilTotalCost' => $gasoilTotalPrice,
            'highwayTotalCost' => $highwaysTotalPrice,
            'reparationsTotalCost' => $reparationsTotalPrice,
            'insuranceFeesTotalCost' => $insuranceTotalPrice
        ));
    }
}
