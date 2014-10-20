<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

use Fsb\Alfred\CoreBundle\Entity\InsuranceFee;
use Fsb\Alfred\DashboardBundle\Form\InsuranceFeeType;

class InsuranceFeeController extends FrontController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $insuranceFee = new InsuranceFee();
        $form = $this->createForm(new InsuranceFeeType(), $insuranceFee);

        $insuranceFees = $em->getRepository('FsbAlfredCoreBundle:InsuranceFee')->findAll();

        return $this->render('FsbAlfredDashboardBundle:Pages/InsuranceFee:index.html.twig', array(
            'insuranceFees' => $insuranceFees,
            'form' => $form->createView(),
            'totalPrice' => $em->getRepository('FsbAlfredCoreBundle:InsuranceFee')->getTotalPrice()
        ));
    }

    public function newAction()
    {
        $insuranceFee = new InsuranceFee();
        $form = $this->createForm(new InsuranceFeeType(), $insuranceFee);

        return $this->render('FsbAlfredDashboardBundle:Pages/InsuranceFee:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createAction()
    {
        $request = $this->getRequest();

        $insuranceFee = new InsuranceFee();
        $form = $this->createForm(new InsuranceFeeType(), $insuranceFee);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($insuranceFee);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre contrat d\'assurance est bien enregistré');

            return $this->redirect($this->generateUrl('fsb_alfred_dashboard_page_insurance_fee'));
        }

        return $this->render('FsbAlfredDashboardBundle:Pages/InsuranceFee:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
