<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

use Fsb\Alfred\CoreBundle\Entity\Gasoil;
use Fsb\Alfred\DashboardBundle\Form\GasoilType;

class GasoilController extends FrontController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gasoil = new Gasoil();
        $form = $this->createForm(new GasoilType(), $gasoil);

        $gasoils = $em->getRepository('FsbAlfredCoreBundle:Gasoil')->findAll();

        return $this->render('FsbAlfredDashboardBundle:Pages/Gasoil:index.html.twig', array(
            'gasoils' => $gasoils,
            'form' => $form->createView(),
            'totalPrice' => $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalPrice(),
            'totalCapacity' => $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalCapacity(),
            'totalAmount' => $em->getRepository('FsbAlfredCoreBundle:Gasoil')->getTotalAmount()
        ));
    }

    public function editAction()
    {
        $gasoil = new Gasoil();
        $form = $this->createForm(new GasoilType(), $gasoil);

        return $this->render('FsbAlfredDashboardBundle:Pages/Gasoil:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createAction()
    {
        $request = $this->getRequest();

        $gasoil = new Gasoil();
        $form = $this->createForm(new GasoilType(), $gasoil);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gasoil);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre plein d\'essence est bien enregistré');

            return $this->redirect($this->generateUrl('fsb_alfred_dashboard_page_gasoil'));
        }

        return $this->render('FsbAlfredDashboardBundle:Pages/Gasoil:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
