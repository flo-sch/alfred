<?php

namespace Fsb\Alfred\DashboardBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext;

use Fsb\Alfred\CoreBundle\Entity\Driver;
use Fsb\Alfred\DashboardBundle\Form\SubscriptionType;

class AuthenticationController extends FrontController
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('FsbAlfredDashboardBundle:Authentication:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        ));
    }

    public function subscribeAction()
    {
        $request = $this->getRequest();

        $driver = new Driver();
        $form = $this->createForm(new SubscriptionType(), $driver);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $driver->setUsername($driver->getEmail());
                $em = $this->getDoctrine()->getManager();

                $driver->setPassword($this->encryptPassword($driver, $driver->getPassword(), $driver->getSalt()));

                $em->persist($driver);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'Merci ! Vous pouvez dès à présent utiliser Alfred :)');

                return $this->redirect($this->generateUrl('fsb_alfred_dashboard_homepage'));
            }
        }

        return $this->render('FsbAlfredDashboardBundle:Authentication:subscribe.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
