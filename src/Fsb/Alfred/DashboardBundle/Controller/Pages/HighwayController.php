<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

use Fsb\Alfred\CoreBundle\Entity\Highway;
use Fsb\Alfred\DashboardBundle\Form\HighwayType;

class HighwayController extends FrontController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $highway = new Highway();
        $form = $this->createForm(new HighwayType(), $highway);

        $highways = $em->getRepository('FsbAlfredCoreBundle:Highway')->findAll();

        return $this->render('FsbAlfredDashboardBundle:Pages/Highway:index.html.twig', array(
            'highways' => $highways,
            'form' => $form->createView(),
            'totalPrice' => $em->getRepository('FsbAlfredCoreBundle:Highway')->getTotalPrice()
        ));
    }

    public function newAction()
    {
        $highway = new Highway();
        $form = $this->createForm(new HighwayType(), $highway);

        return $this->render('FsbAlfredDashboardBundle:Pages/Highway:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createAction()
    {
        $request = $this->getRequest();

        $highway = new Highway();
        $form = $this->createForm(new HighwayType(), $highway);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($highway);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre contrat d\'assurance est bien enregistré');

            return $this->redirect($this->generateUrl('fsb_alfred_dashboard_page_highway'));
        }

        return $this->render('FsbAlfredDashboardBundle:Pages/Highway:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
