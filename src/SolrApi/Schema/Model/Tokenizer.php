<?php

declare(strict_types=1);

/*
 * This file is part of the SolrPHP SolariumBundle.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solrphp\SolariumBundle\SolrApi\Schema\Model;

/**
 * Tokenizer.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
final class Tokenizer implements \JsonSerializable
{
    /**
     * @var string
     */
    private string $class;

    /**
     * @var string|null
     */
    private ?string $pattern = null;

    /**
     * @var int|null
     */
    private ?int $minGramSize = null;

    /**
     * @var int|null
     */
    private ?int $maxGramSize = null;

    /**
     * @var string|null
     */
    private ?string $delimiter = null;

    /**
     * @var string|null
     */
    private ?string $replace = null;

    /**
     * @var int|null
     */
    private ?int $group = null;

    /**
     * @var string|null
     */
    private ?string $rule = null;

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    /**
     * @return string|null
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * @param string|null $pattern
     */
    public function setPattern(?string $pattern): void
    {
        $this->pattern = $pattern;
    }

    /**
     * @return int|null
     */
    public function getMinGramSize(): ?int
    {
        return $this->minGramSize;
    }

    /**
     * @param int|null $minGramSize
     */
    public function setMinGramSize(?int $minGramSize): void
    {
        $this->minGramSize = $minGramSize;
    }

    /**
     * @return int|null
     */
    public function getMaxGramSize(): ?int
    {
        return $this->maxGramSize;
    }

    /**
     * @param int|null $maxGramSize
     */
    public function setMaxGramSize(?int $maxGramSize): void
    {
        $this->maxGramSize = $maxGramSize;
    }

    /**
     * @return string|null
     */
    public function getDelimiter(): ?string
    {
        return $this->delimiter;
    }

    /**
     * @param string|null $delimiter
     */
    public function setDelimiter(?string $delimiter): void
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @return string|null
     */
    public function getReplace(): ?string
    {
        return $this->replace;
    }

    /**
     * @param string|null $replace
     */
    public function setReplace(?string $replace): void
    {
        $this->replace = $replace;
    }

    /**
     * @return int|null
     */
    public function getGroup(): ?int
    {
        return $this->group;
    }

    /**
     * @param int|null $group
     */
    public function setGroup(?int $group): void
    {
        $this->group = $group;
    }

    /**
     * @return string|null
     */
    public function getRule(): ?string
    {
        return $this->rule;
    }

    /**
     * @param string|null $rule
     */
    public function setRule(?string $rule): void
    {
        $this->rule = $rule;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_filter(
            [
                'class' => $this->class,
                'pattern' => $this->pattern,
                'minGramSize' => $this->minGramSize,
                'maxGramSize' => $this->maxGramSize,
                'delimiter' => $this->delimiter,
                'replace' => $this->replace,
                'group' => $this->group,
                'rule' => $this->rule,
            ],
            static function ($var) {
                return null !== $var;
            }
        );
    }
}
