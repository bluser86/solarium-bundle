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

/**
 * AbstractResponse.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
abstract class AbstractResponse
{
    /**
     * @var \Solrphp\SolariumBundle\SolrApi\Response\Header
     */
    private Header $responseHeader;

    /**
     * @var \Solrphp\SolariumBundle\SolrApi\Response\Error|null
     */
    private ?Error $error = null;

    /**
     * @return \Solrphp\SolariumBundle\SolrApi\Response\Header
     */
    public function getResponseHeader(): Header
    {
        return $this->responseHeader;
    }

    /**
     * @param \Solrphp\SolariumBundle\SolrApi\Response\Header $responseHeader
     */
    public function setResponseHeader(Header $responseHeader): void
    {
        $this->responseHeader = $responseHeader;
    }

    /**
     * @return \Solrphp\SolariumBundle\SolrApi\Response\Error|null
     */
    public function getError(): ?Error
    {
        return $this->error;
    }

    /**
     * @param \Solrphp\SolariumBundle\SolrApi\Response\Error|null $error
     */
    public function setError(?Error $error): void
    {
        $this->error = $error;
    }
}
