<?php

declare(strict_types=1);

namespace AppBundle\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Psr\Log\LoggerInterface;

final class UserInGroupFilter extends AbstractContextAwareFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $firstAssociation = explode('_', $property);

        if (
            !$this->isPropertyEnabled($firstAssociation[0], $resourceClass) ||
            !$this->isPropertyMapped($firstAssociation[0], $resourceClass, true)
        ) {
            return;
        }

        if ($property !== 'user_in_groups') {
            return;
        }

        $value = is_array($value) ? $value : [$value];

        $parameterName = $queryNameGenerator->generateParameterName($property); // Generate a unique parameter name to avoid collisions with other filters
        $queryBuilder
            ->join('o.user', 'u')
            ->join('u.groups', 'g', Join::WITH, sprintf('g.id in (:%s)', $parameterName))
            ->setParameter($parameterName, implode(',', $value));
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["regexp_$property"] = [
                'property' => $property,
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter using a regex. This will appear in the Swagger documentation!',
                    'name' => 'Custom name to use in the Swagger documentation',
                    'type' => 'Will appear below the name in the Swagger documentation',
                ],
            ];
        }

        return $description;
    }
}