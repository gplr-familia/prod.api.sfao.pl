<?php

namespace AppBundle\Doctrine\ORM\Extension;

use AppBundle\Entity\Recommendation;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class AdminUserExtension
 *
 * @package AppBundle\Doctrine\ORM\Extension
 */
final class AdminUserExtension
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * CurrentUserExtension constructor.
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationChecker                 $checker
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationChecker $checker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $checker;
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $token = $this->tokenStorage->getToken();
        $entity = $args->getEntity();

        if (null !== $token && $entity instanceof Recommendation && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $entity->setCreatedBy($token->getUser());
        }
    }
}