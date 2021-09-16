<?php

declare(strict_types=1);

/*
 * This file is part of the SolrPHP SolariumBundle.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solrphp\SolariumBundle\Generator;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use Solrphp\SolariumBundle\SolrApi\Config\Model\Query;
use Solrphp\SolariumBundle\SolrApi\Config\Model\RequestHandler;
use Solrphp\SolariumBundle\SolrApi\Config\Model\SearchComponent;
use Solrphp\SolariumBundle\SolrApi\Config\SolrConfig;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Config Generator.
 *
 * @author wicliff <wwolda@gmail.com>
 */
class ConfigGenerator
{
    /**
     * @var \Symfony\Component\Serializer\Serializer
     */
    private Serializer $serializer;

    /**
     * constructor.
     */
    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $discriminator = new ClassDiscriminatorFromClassMetadata($classMetadataFactory);
        $this->serializer = new Serializer([new ArrayDenormalizer(), new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter(), null, new ReflectionExtractor(), $discriminator)]);
    }

    /**
     * @param array<int, array> $configs
     *
     * @return \Generator<int, \Solrphp\SolariumBundle\Contract\SolrApi\CoreDependentConfigInterface>
     */
    public function generate(array $configs): \Generator
    {
        foreach ($configs as $config) {
            foreach ($config['search_components'] as $key => $searchComponent) {
                $config['search_components'][$key] = $this->serializer->denormalize($searchComponent, SearchComponent::class);
            }

            foreach ($config['request_handlers'] as $key => $requestHandler) {
                $config['request_handlers'][$key] = $this->serializer->denormalize($requestHandler, RequestHandler::class);
            }

            if (false === empty($config['query'])) {
                $config['query'] = $this->serializer->denormalize($config['query'], Query::class);
            } else {
                $config['query'] = null;
            }

            yield new SolrConfig(new ArrayCollection($config['cores']), new ArrayCollection($config['search_components']), new ArrayCollection($config['request_handlers']), $config['query']);
        }
    }
}
