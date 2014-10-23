<?php

namespace Fsb\Alfred\DashboardBundle\Controller;

use \Swift_Message;

use Symfony\Component\Security\Core\SecurityContext;

use Fsb\Alfred\CoreBundle\Entity\Driver;
use Fsb\Alfred\DashboardBundle\Form\SubscriptionType;
use Fsb\Alfred\DashboardBundle\Form\LostPasswordType;
use Fsb\Alfred\DashboardBundle\Form\ResetPasswordType;

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

                $request->getSession()->getFlashBag()->add('success', 'Merci ! Vous pouvez dès à présent consulter Alfred :)');

                return $this->redirect($this->generateUrl('fsb_alfred_dashboard_homepage'));
            }
        }

        return $this->render('FsbAlfredDashboardBundle:Authentication:subscribe.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function lostPasswordAction()
    {
        $request = $this->getRequest();

        $form = $this->createForm(new LostPasswordType());

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $data = $form->getData();

                $email = $data['email'];

                $driver = $em->getRepository('FsbAlfredCoreBundle:Driver')->loadUserByUsername($email);

                if (!$driver) {
                    throw $this->createNotFoundException('Aie... Cette adresse e-mail n\'appartient à aucune connaissance ici...');
                }

                $driver->setLostPasswordToken($this->generateToken());

                $em->persist($driver);
                $em->flush();

                $message = Swift_Message::newInstance()
                    ->setSubject('[alfredhelps.me] Mot de passe oublié')
                    ->setFrom($this->container->getParameter('mailer_from'))
                    ->setTo($driver->getEmail())
                    ->setBody($this->render('FsbAlfredDashboardBundle:Authentication:reset-password.mail.html.twig', array(
                        'username' => base64_encode($driver->getUsername()),
                        'token' => base64_encode($driver->getLostPasswordToken())
                    )))
                ;
                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Un mail contenant un lien pour redéfinir votre mot de passe va vous être envoyé !');

                return $this->redirect($this->generateUrl('fsb_alfred_dashboard_page_reset_password', array(
                    'username' => base64_encode($driver->getUsername()),
                    'token' => base64_encode($driver->getLostPasswordToken())
                )));
                return $this->redirect($this->generateUrl('fsb_alfred_dashboard_homepage'));
            }
        }

        return $this->render('FsbAlfredDashboardBundle:Authentication:lost-password.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function resetPasswordAction($username, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

        $username = base64_decode($username);
        $token = base64_decode($token);

        $driver = $em->getRepository('FsbAlfredCoreBundle:Driver')->loadUserByUsername($username);

        if (!$driver) {
            throw $this->createNotFoundException('Aie... Mais qui êtes vous donc ?');
        }

        if ($token === $driver->getLostPasswordToken()) {
            $form = $this->createForm(new ResetPasswordType());

            if ($request->getMethod() === 'POST') {
                $form->handleRequest($request);

                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $data = $form->getData();

                    $driver->setLostPasswordToken(null);
                    $driver->setPassword($this->encryptPassword($driver, $data['password'], $driver->getSalt()));

                    $em->persist($driver);
                    $em->flush();

                    $request->getSession()->getFlashBag()->add('success', 'Votre mot de passe a bien été redéfini !');

                    return $this->redirect($this->generateUrl('fsb_alfred_dashboard_homepage'));
                }
            }
        } else {
            $request->getSession()->getFlashBag()->add('error', 'Le jeton d\'accès est incorrect !');
        }

        return $this->render('FsbAlfredDashboardBundle:Authentication:reset-password.html.twig', array(
            'form' => $form->createView(),
            'username' => base64_encode($username),
            'token' => base64_encode($token),
        ));
    }
}
