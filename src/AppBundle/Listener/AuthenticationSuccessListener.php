<?php

declare(strict_types=1);

namespace AppBundle\Listener;

use FOS\UserBundle\Model\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['data'] = array(
            'roles' => $user->getRoles(),
            'fullname' => $user->getFullname(),
            'id' => $user->getId()
        );

        $event->setData($data);
    }
}