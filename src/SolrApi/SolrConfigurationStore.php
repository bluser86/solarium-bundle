<?php

declare(strict_types=1);

/*
 * This file is part of the SolrPHP SolariumBundle.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solrphp\SolariumBundle\SolrApi;

use Solrphp\SolariumBundle\Common\Generator\LazyLoadingGenerator;
use Solrphp\SolariumBundle\SolrApi\Config\Config\SolrConfig;
use Solrphp\SolariumBundle\SolrApi\Config\Generator\ConfigGenerator;
use Solrphp\SolariumBundle\SolrApi\Schema\Config\ManagedSchema;
use Solrphp\SolariumBundle\SolrApi\Schema\Generator\SchemaGenerator;

/**
 * Solr Configuration Store.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class SolrConfigurationStore
{
    /**
     * @var LazyLoadingGenerator<\Generator<int, \Solrphp\SolariumBundle\Contract\SolrApi\CoreDependentConfigInterface>>
     */
    private LazyLoadingGenerator $managedSchemas;

    /**
     * @var LazyLoadingGenerator<\Generator<int, \Solrphp\SolariumBundle\Contract\SolrApi\CoreDependentConfigInterface>>
     */
    private LazyLoadingGenerator $solrConfigs;

    /**
     * @param array<int, array<string, ManagedSchema>> $managedSchemas
     * @param array<int, array<string, SolrConfig>>    $solrConfigs
     */
    public function __construct(array $managedSchemas, array $solrConfigs)
    {
        $this->managedSchemas = new LazyLoadingGenerator($this->initSchemas($managedSchemas));
        $this->solrConfigs = new LazyLoadingGenerator($this->initConfigs($solrConfigs));
    }

    /**
     * @param string $core
     *
     * @return \Solrphp\SolariumBundle\SolrApi\Schema\Config\ManagedSchema|null
     */
    public function getSchemaForCore(string $core): ?ManagedSchema
    {
        foreach ($this->managedSchemas as $schema) {
            if (true === \in_array($core, $schema->getCores()->toArray(), true)) {
                return $schema;
            }
        }

        return null;
    }

    /**
     * @param string $core
     *
     * @return \Solrphp\SolariumBundle\SolrApi\Config\Config\SolrConfig|null
     */
    public function getConfigForCore(string $core): ?SolrConfig
    {
        foreach ($this->solrConfigs as $config) {
            if (true === \in_array($core, $config->getCores()->toArray(), true)) {
                return $config;
            }
        }

        return null;
    }

    /**
     * @param array<int, array<string, SolrConfig>> $configs
     *
     * @return \Generator<int, \Solrphp\SolariumBundle\Contract\SolrApi\CoreDependentConfigInterface>
     */
    private function initConfigs(array $configs): \Generator
    {
        return (new ConfigGenerator())->generate($configs);
    }

    /**
     * @param array<int, array<string, ManagedSchema>> $schemas
     *
     * @return \Generator<int, \Solrphp\SolariumBundle\Contract\SolrApi\CoreDependentConfigInterface>
     */
    private function initSchemas(array $schemas): \Generator
    {
        return (new SchemaGenerator())->generate($schemas);
    }
}
