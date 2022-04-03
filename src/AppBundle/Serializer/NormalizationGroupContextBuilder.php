<?php

namespace AppBundle\Serializer;

use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use AppBundle\Entity\Measurement;
use AppBundle\Entity\Recommendation;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NormalizationGroupContextBuilder
 *
 * @package AppBundle\Serializer
 */
class NormalizationGroupContextBuilder implements SerializerContextBuilderInterface
{
    const SUPPORTED_CLASSES = [
        Recommendation::class,
        Measurement::class
    ];
    /**
     * @var \ApiPlatform\Core\Serializer\SerializerContextBuilderInterface
     */
    private $builder;

    /**
     * NormalizationGroupContextBuilder constructor.
     *
     * @param \ApiPlatform\Core\Serializer\SerializerContextBuilderInterface $builder
     */
    public function __construct(SerializerContextBuilderInterface $builder)
    {

        $this->builder = $builder;
    }

    /**
     * Creates a serialization context from a Request.
     *
     * @param Request    $request
     * @param bool       $normalization
     * @param array|null $extractedAttributes
     *
     * @throws RuntimeException
     *
     * @return array
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->builder->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;

        $groups = $request->get('groups', []);

        if (is_string($groups)) {
            $groups = [$groups];
        }

        if (in_array($resourceClass, static::SUPPORTED_CLASSES) && isset($context['groups']) && count($groups)) {
            $context['groups'] = array_merge($context['groups'], $groups);
        }

        return $context;
    }
}