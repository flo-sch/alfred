<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

use Fsb\Alfred\CoreBundle\Entity\Reparation;
use Fsb\Alfred\DashboardBundle\Form\ReparationType;

class ReparationController extends FrontController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reparation = new Reparation();
        $form = $this->createForm(new ReparationType(), $reparation);

        $reparations = $em->getRepository('FsbAlfredCoreBundle:Reparation')->findAll();

        $totalAmount = $em->getRepository('FsbAlfredCoreBundle:Reparation')->getTotalPrice();

        return $this->render('FsbAlfredDashboardBundle:Pages/Reparation:index.html.twig', array(
            'reparations' => $reparations,
            'form' => $form->createView(),
            'totalAmount' => $totalAmount
        ));
    }

    public function newAction()
    {
        $reparation = new Reparation();
        $form = $this->createForm(new ReparationType(), $reparation);

        return $this->render('FsbAlfredDashboardBundle:Pages/Reparation:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createAction()
    {
        $request = $this->getRequest();

        $reparation = new Reparation();
        $form = $this->createForm(new ReparationType(), $reparation);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reparation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre réparation est bien enregistré');

            return $this->redirect($this->generateUrl('fsb_alfred_dashboard_page_reparation'));
        }

        return $this->render('FsbAlfredDashboardBundle:Pages/Reparation:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
