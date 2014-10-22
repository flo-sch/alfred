<?php

namespace Fsb\Alfred\DashboardBundle\Controller\Pages;

use Fsb\Alfred\DashboardBundle\Controller\FrontController;

use Fsb\Alfred\CoreBundle\Entity\Driver;
use Fsb\Alfred\DashboardBundle\Form\ProfileType;
use Fsb\Alfred\DashboardBundle\Form\DriverPasswordType;

class ProfileController extends FrontController
{
    public function editAction()
    {
        $request = $this->getRequest();

        $driver = $this->getUser();
        $form = $this->createForm(new ProfileType(), $driver);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($driver);

                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'Votre profil a bien été édité !');

                return $this->redirect($this->generateUrl('fsb_alfred_dashboard_homepage'));
            }
        }

        return $this->render('FsbAlfredDashboardBundle:Pages/Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editPasswordAction()
    {
        $request = $this->getRequest();

        $driver = $this->getUser();
        $form = $this->createForm(new DriverPasswordType(), $driver);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $currentPassword = $this->encryptPassword($driver, $driver->getCurrentPassword(), $driver->getSalt());

                if ($currentPassword === $driver->getPassword()) {
                    $driver->setPassword($this->encryptPassword($driver, $driver->getNewPassword(), $driver->getSalt()));

                    $em->persist($driver);
                    $em->flush();

                    $request->getSession()->getFlashBag()->add('success', 'Votre mot de passe a bien été mis à jour !');

                    return $this->redirect($this->generateUrl('fsb_alfred_dashboard_page_profile'));
                } else {
                    $request->getSession()->getFlashBag()->add('error', 'Le mot de passe actuel est incorret !');
                }
            }
        }

        return $this->render('FsbAlfredDashboardBundle:Pages/Profile:edit-password.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
