<?php

declare(strict_types=1);

/*
 * This file is part of the SolrPHP SolariumBundle.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solrphp\SolariumBundle\Common\Response;

use Solrphp\SolariumBundle\Contract\SolrApi\Response\ResponseErrorInterface;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * Error.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
class Error implements ResponseErrorInterface
{
    /**
     * @var string[]
     */
    private array $metadata = [];

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("msg")
     */
    private ?string $message = null;

    /**
     * @var int
     */
    private int $code;

    /**
     * @return string[]
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param string[] $metadata
     */
    public function setMetadata(array $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }
}
