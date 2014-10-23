<?php

namespace Fsb\Alfred\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    protected function encryptPassword($user, $password, $salt)
    {
        $encryptedPassword = null;

        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        if (!$encoder) {
            throw $this->createNotFoundException(sprintf('Unknown entity : %s', get_class($user)));
        }

        $encryptedPassword = $encoder->encodePassword($password, $salt);

        return $encryptedPassword;
    }

    protected function generateToken()
    {
        return sha1(uniqid(mt_rand(), true));
    }
}
