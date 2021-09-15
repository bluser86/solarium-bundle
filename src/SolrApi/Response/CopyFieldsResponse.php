<?php

declare(strict_types=1);

/*
 * This file is part of the SolrPHP SolariumBundle.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solrphp\SolariumBundle\SolrApi\Response;

use Doctrine\Common\Collections\ArrayCollection;
use Solrphp\SolariumBundle\SolrApi\Config\CopyField;

/**
 * Copy Fields Response.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class CopyFieldsResponse extends AbstractResponse
{
    /**
     * @var ArrayCollection<int, \Solrphp\SolariumBundle\SolrApi\Config\CopyField>
     */
    private ArrayCollection $copyFields;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->copyFields = new ArrayCollection();
    }

    /**
     * @return ArrayCollection<int, \Solrphp\SolariumBundle\SolrApi\Config\CopyField>
     */
    public function getCopyFields(): ArrayCollection
    {
        return $this->copyFields;
    }

    /**
     * @param \Solrphp\SolariumBundle\SolrApi\Config\CopyField $copyField
     */
    public function addCopyField(CopyField $copyField): void
    {
        $this->copyFields->add($copyField);
    }

    /**
     * @param \Solrphp\SolariumBundle\SolrApi\Config\CopyField $copyField
     */
    public function removeCopyField(CopyField $copyField): void
    {
        $this->copyFields->removeElement($copyField);
    }
}
