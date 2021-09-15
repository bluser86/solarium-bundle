<?php

declare(strict_types=1);

/*
 * This file is part of the SolrPHP SolariumBundle.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solrphp\SolariumBundle\Tests\Unit\SolrApi\Command;

use PHPUnit\Framework\TestCase;
use Solrphp\SolariumBundle\SolrApi\Command\CommandCollection;
use Solrphp\SolariumBundle\SolrApi\Config\FieldType;
use Solrphp\SolariumBundle\SolrApi\Config\Property;

/**
 * CommandCollection Test.
 *
 * @author wicliff <wwolda@gmail.com>
 */
class CommandCollectionTest extends TestCase
{
    /**
     * @var \Solrphp\SolariumBundle\SolrApi\Command\CommandCollection
     */
    private CommandCollection $collection;

    /**
     * set up.
     */
    protected function setUp(): void
    {
        $this->collection = new CommandCollection([]);
    }

    /**
     * test set.
     */
    public function testSet(): void
    {
        $this->collection->set('foo', ['bar']);

        self::assertTrue($this->collection->containsCommand('foo'));
        self::assertNotNull($this->collection->get('foo'));
    }

    /**
     * test add.
     */
    public function testAdd(): void
    {
        $this->collection->add('foo', new FieldType());

        self::assertTrue($this->collection->containsCommand('foo'));
        self::assertInstanceOf(FieldType::class, $this->collection->get('foo')[0]);
    }

    /**
     * test remove.
     */
    public function testRemove(): void
    {
        $this->collection->add('foo', new FieldType());

        $removed = $this->collection->remove('foo');

        self::assertInstanceOf(FieldType::class, $removed[0]);
        self::assertFalse($this->collection->containsCommand('foo'));
    }

    /**
     * test remove non-existing.
     */
    public function testRemoveNonExisting(): void
    {
        $removed = $this->collection->remove('foo');

        self::assertNull($removed);
    }

    /**
     * test contains.
     */
    public function testContains(): void
    {
        $collection = new CommandCollection([null]);
        $collection->add('foo', new FieldType());

        self::assertTrue($collection->containsCommand('foo'));
        self::assertTrue($collection->containsCommand(0));
    }

    /**
     * test clear.
     */
    public function testClear(): void
    {
        $this->collection->add('foo', new FieldType());

        $this->collection->clear();

        self::assertCount(0, $this->collection->getIterator());
    }

    /**
     * test offset exists.
     */
    public function testOffsetExists(): void
    {
        $this->collection->add('foo', new FieldType());

        self::assertTrue($this->collection->offsetExists('foo'));
    }

    /**
     * test offset get.
     */
    public function testOffsetGet(): void
    {
        $field = new FieldType();
        $this->collection->add('foo', $field);

        self::assertSame($field, $this->collection->offsetGet('foo')[0]);
    }

    /**
     * test offset set.
     */
    public function testOffsetSet(): void
    {
        $field = new FieldType();
        $property = new Property('foo', 'bar');

        $this->collection->add('foo', $field);
        $this->collection->offsetSet('foo', [$property]);

        self::assertSame($property, $this->collection->offsetGet('foo')[0]);
    }

    /**
     * test offset unset.
     */
    public function testOffsetUnset(): void
    {
        $field = new FieldType();

        $this->collection->offsetSet('foo', [$field]);

        self::assertSame($field, $this->collection->offsetGet('foo')[0]);

        $this->collection->offsetUnset('foo');
        self::assertNull($this->collection->get('foo'));
    }

    /**
     * test json serialize.
     */
    public function testJsonSerialize(): void
    {
        $collection = new CommandCollection([
            'foo' => null,
            'bar' => new FieldType(),
        ]);

        self::assertArrayHasKey('bar', $collection->jsonSerialize());
        self::assertArrayNotHasKey('foo', $collection->jsonSerialize());
    }
}
