<?php

namespace AppBundle\Doctrine\ORM\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use AppBundle\Entity\Appointment;
use AppBundle\Entity\DietRecommendation;
use AppBundle\Entity\Drug;
use AppBundle\Entity\ImagingExamination;
use AppBundle\Entity\InformationForPatient;
use AppBundle\Entity\Meal;
use AppBundle\Entity\Measurement;
use AppBundle\Entity\Notification;
use AppBundle\Entity\PhysicalEffort;
use AppBundle\Entity\Recommendation;
use AppBundle\Entity\User;
use AppBundle\Entity\Summary;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class CurrentUserExtension
 *
 * @package AppBundle\Doctrine\ORM\Extension
 */
final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
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
     * List of classes which are extended by current user context.
     *
     * @var array
     */
    private static $currentUserModels = [
        Measurement::class,
        Recommendation::class,
        ImagingExamination::class,
        Notification::class,
        DietRecommendation::class,
        Meal::class,
        PhysicalEffort::class,
        InformationForPatient::class,
        Summary::class,
        Drug::class
    ];

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

        if (null !== $token && $entity instanceof Measurement && !$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $entity->setUser($token->getUser());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     *
     * @param QueryBuilder $queryBuilder
     * @param string       $resourceClass
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User && !$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $rootAlias = $queryBuilder->getRootAliases()[0];

            if (in_array($resourceClass, $this::$currentUserModels)) {
                $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
                $queryBuilder->setParameter('current_user', $user->getId());
            }

            if (User::class === $resourceClass) {
                $patientAlias = 'patients_X';
                $queryBuilder->leftJoin(
                    sprintf('%s.patients', $rootAlias),
                    $patientAlias,
                    'WITH',
                    sprintf('%s.id = :user_id', $patientAlias)
                );
                $queryBuilder->setParameter('user_id', $user->getId());
            }

            if (Appointment::class === $resourceClass) {
                $queryBuilder->andWhere(sprintf('%s.patient = :current_user', $rootAlias));
                $queryBuilder->setParameter('current_user', $user->getId());
            }
        }
    }
}