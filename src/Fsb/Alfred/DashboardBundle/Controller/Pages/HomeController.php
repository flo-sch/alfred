<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

class HomeController extends FrontController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $driver = $this->getUser();

        $drivenDistance = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getKilometersDifference();

        $averageConsommation = 0;
        $averageGasoilPrice = 0;

        $averagePrice = 0;
        $gasoilTotalPrice = 0;
        $highwaysTotalPrice = 0;
        $insuranceTotalPrice = 0;
        $reparationsTotalPrice = 0;

        if ($drivenDistance > 0) {
            if ($driver->wouldManageGasoil()) {
                $averageConsommation = 100 * ($em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalCapacity() - $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getLastCapacity()) / $drivenDistance;
                $averageGasoilPrice = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getAverageLiterPrice();
                $gasoilTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalAmount();
                $averagePrice += $gasoilTotalPrice;
            }
            if ($driver->wouldManageHighway()) {
                $highwaysTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Highway')->getTotalPrice();
                $averagePrice += $highwaysTotalPrice;
            }
            if ($driver->wouldManageInsuranceFee()) {
                $insuranceTotalPrice = $em->getRepository('FsbAlfredCoreBundle:InsuranceFee')->getTotalPrice();
                $averagePrice += $insuranceTotalPrice;
            }
            if ($driver->wouldManageReparations()) {
                $reparationsTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Reparation')->getTotalPrice();
                $averagePrice += $reparationsTotalPrice;
            }

            $averagePrice /= $drivenDistance;
        }

        return $this->render('FsbAlfredDashboardBundle:Pages/Home:index.html.twig', array(
            'averageConsommation' => $averageConsommation,
            'averageLiterPrice' => $averageGasoilPrice,
            'averageCost' => $averagePrice,
            'gasoilTotalCost' => $gasoilTotalPrice,
            'highwayTotalCost' => $highwaysTotalPrice,
            'insuranceFeesTotalCost' => $insuranceTotalPrice,
            'reparationsTotalCost' => $reparationsTotalPrice
        ));
    }
}
