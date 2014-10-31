<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

class HomeController extends FrontController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $driver = $this->getUser();

        $gasoilDrivenDistance = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getMaxKilometersForDriver($driver);
        $drivenDistance = max($driver->getCurrentKilometers(), $gasoilDrivenDistance) - $driver->getInitialKilometers();

        $averageConsommation = 0;
        $averageGasoilPrice = 0;

        $averagePrice = 0;
        $gasoilTotalPrice = 0;
        $highwaysTotalPrice = 0;
        $insuranceTotalPrice = 0;
        $reparationsTotalPrice = 0;

        if ($drivenDistance > 0) {
            if ($driver->wouldManageGasoil()) {
                $averageConsommation = 100 * ($em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalCapacityForDriver($driver) - $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getLastCapacityForDriver($driver)) / $drivenDistance;
                $averageGasoilPrice = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getAverageLiterPriceForDriver($driver);
                $gasoilTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalAmountForDriver($driver);
                $averagePrice += $gasoilTotalPrice;
            }
            if ($driver->wouldManageHighway()) {
                $highwaysTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Highway')->getTotalPriceForDriver($driver);
                $averagePrice += $highwaysTotalPrice;
            }
            if ($driver->wouldManageInsuranceFee()) {
                $insuranceTotalPrice = $em->getRepository('FsbAlfredCoreBundle:InsuranceFee')->getTotalPriceForDriver($driver);
                $averagePrice += $insuranceTotalPrice;
            }
            if ($driver->wouldManageReparations()) {
                $reparationsTotalPrice = $em->getRepository('FsbAlfredCoreBundle:Reparation')->getTotalPriceForDriver($driver);
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
            'reparationsTotalCost' => $reparationsTotalPrice,
            'drivenDistance' => $drivenDistance
        ));
    }
}
