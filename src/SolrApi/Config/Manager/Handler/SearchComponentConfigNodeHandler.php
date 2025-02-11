<?php

declare(strict_types=1);

/*
 * This file is part of the SolrPHP SolariumBundle.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solrphp\SolariumBundle\SolrApi\Config\Manager\Handler;

use Doctrine\Common\Collections\Criteria;
use Solrphp\SolariumBundle\Common\Manager\IterableConfigNode;
use Solrphp\SolariumBundle\Contract\SolrApi\Manager\ConfigNodeHandlerInterface;
use Solrphp\SolariumBundle\Contract\SolrApi\Manager\ConfigNodeInterface;
use Solrphp\SolariumBundle\Contract\SolrApi\Manager\SolrApiManagerInterface;
use Solrphp\SolariumBundle\Exception\ProcessorException;
use Solrphp\SolariumBundle\Exception\UnexpectedValueException;
use Solrphp\SolariumBundle\SolrApi\Config\Enum\Command;
use Solrphp\SolariumBundle\SolrApi\Config\Model\SearchComponent;
use Solrphp\SolariumBundle\SolrApi\Config\Response\ConfigResponse;

/**
 * SearchComponent ConfigNode Handler.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class SearchComponentConfigNodeHandler implements ConfigNodeHandlerInterface
{
    /**
     * @var \Solrphp\SolariumBundle\Contract\SolrApi\Manager\SolrApiManagerInterface
     */
    private SolrApiManagerInterface $manager;

    /**
     * @param \Solrphp\SolariumBundle\Contract\SolrApi\Manager\SolrApiManagerInterface $manager
     *
     * @return \Solrphp\SolariumBundle\Contract\SolrApi\Manager\ConfigNodeHandlerInterface
     */
    public function setManager(SolrApiManagerInterface $manager): ConfigNodeHandlerInterface
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(ConfigNodeInterface $configNode): void
    {
        if (!$configNode instanceof IterableConfigNode) {
            throw new ProcessorException(sprintf('invalid config node use %s', IterableConfigNode::class));
        }

        try {
            $current = $this->manager->call($configNode->getPath());
        } catch (UnexpectedValueException $e) {
            throw new ProcessorException(sprintf('unable to retrieve search component config for sub path %s', $configNode->getPath()), $e);
        }

        if (!$current instanceof ConfigResponse) {
            throw new ProcessorException(sprintf('invalid response for sub path %s', $configNode->getPath()));
        }

        foreach ($configNode->get() as $component) {
            $criteria = Criteria::create()
                ->andWhere(Criteria::expr()->eq('name', $component->getName()))
            ;

            $command = $current->getConfig()->getSearchComponents()->matching($criteria)->isEmpty() ? Command::ADD_SEARCH_COMPONENT : Command::UPDATE_SEARCH_COMPONENT;

            try {
                $this->manager->addCommand($command, $component);
            } catch (UnexpectedValueException $e) {
                throw new ProcessorException(sprintf('unable to add command %s for type %s', $command, $configNode->getType()), $e);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ConfigNodeInterface $configNode): bool
    {
        return SearchComponent::class === $configNode->getType();
    }

    /**
     * @return int
     */
    public static function getDefaultPriority(): int
    {
        return ConfigNodeHandlerInterface::PRIORITY;
    }
}
