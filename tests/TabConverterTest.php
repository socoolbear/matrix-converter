<?php

declare(strict_types=1);

/*
 * This file is part of this package.
 *
 * (c) SoCoolBear <socoolbear@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SpecConverter\Tests;

use PHPUnit\Framework\TestCase;
use SpecConverter\TabConverter;

/**
 * Test class for JsonConverter.
 *
 * @coversNothing
 */
class TabConverterTest extends TestCase
{
    use ConverterCommonTestFunctions;

    public function setUp()
    {
        $this->conv = new TabConverter();
    }

    public function testToMatrixArgsBaseFormat()
    {
        $this->assertTrue($this->assertToMatrixInvalidArgument('not json'));
        $this->assertTrue($this->assertToMatrixInvalidArgument('{}'));
    }

    public function testToMatrixArgFormat()
    {
        $args = json_encode(['count' => 'not exist trados field']);
        $this->assertTrue($this->assertToMatrixInvalidArgument($args));

        $args = json_encode(['count' => ['trados' => 'not int']]);
        $this->assertTrue($this->assertToMatrixInvalidArgument($args));

        $args = json_encode(['count' => ['trados' => -1]]);
        $this->assertTrue($this->assertToMatrixInvalidArgument($args));

        $args = json_encode(['count' => ['trados' => 0]]);
        $this->assertTrue($this->assertToMatrixInvalidArgument($args));

        $args = json_encode(['count' => ['trados' => 0], 'data' => 'not array']);
        $this->assertTrue($this->assertToMatrixInvalidArgument($args));

        $args = json_encode(['count' => ['trados' => 0], 'data' => ['invalid format']]);
        $this->assertTrue($this->assertToMatrixInvalidArgument($args));

        $field3 = new \stdclass();
        $field3->from = 'seo.translate_dictionary_source';
        $field3->keyword = '';
        $field3->result = '';
        $field3->type = 'unit'; //test - first row must `head`
        $args = json_encode(['count' => ['trados' => 0], 'data' => [[$field3]]]);
        $this->assertTrue($this->assertToMatrixInvalidArgument($args));
    }

    public function testToMatrix()
    {
        $args = json_encode(['count' => ['trados' => 0], 'data' => []]);
        $this->assertSame('', $this->conv->toMatrix($args));

        $field3 = new \stdclass();
        $field3->from = 'seo.translate_dictionary_source';
        $field3->keyword = 'a';
        $field3->result = 'a';
        $field3->type = 'head';
        $args = json_encode(['count' => ['trados' => 0], 'data' => [[$field3]]]);
        $this->assertSame('a', $this->conv->toMatrix($args));

        $field = new \stdclass();
        $field->from = 'seo.translate_dictionary_source';
        $field->keyword = 'a';
        $field->result = 'a';
        $field->type = 'head';
        $field2 = new \stdclass();
        $field2->from = 'seo.translate_dictionary_source';
        $field2->keyword = 'b';
        $field2->result = 'b';
        $field2->type = 'head';
        $args = json_encode(['count' => ['trados' => 0], 'data' => [[$field, $field2]]]);
        $this->assertSame("a\tb", $this->conv->toMatrix($args));

        $field = new \stdclass();
        $field->from = 'seo.translate_dictionary_source';
        $field->keyword = 'a';
        $field->result = 'a';
        $field->type = 'head';
        $field2 = new \stdclass();
        $field2->from = 'seo.translate_dictionary_source';
        $field2->keyword = 'b';
        $field2->result = 'b';
        $field2->type = 'head';
        $field3 = new \stdclass();
        $field3->from = 'seo.translate_dictionary_source';
        $field3->keyword = 'c';
        $field3->result = 'c';
        $field3->type = 'body';
        $field4 = new \stdclass();
        $field4->from = 'seo.translate_dictionary_source';
        $field4->keyword = 'd';
        $field4->result = 'd';
        $field4->type = 'body';
        $args = json_encode(['count' => ['trados' => 0], 'data' => [[$field, $field2], [$field3, $field4]]]);
        $this->assertSame("a\tb".PHP_EOL."c\td", $this->conv->toMatrix($args));

        $field = new \stdclass();
        $field->from = 'seo.translate_dictionary_source';
        $field->keyword = 'a';
        $field->result = 'a';
        $field->type = 'head';
        $field2 = new \stdclass();
        $field2->from = 'seo.translate_dictionary_source';
        $field2->keyword = 'b';
        $field2->result = 'b';
        $field2->type = 'head';
        $field3 = new \stdclass();
        $field3->from = 'seo.translate_dictionary_source';
        $field3->keyword = 'c';
        $field3->result = 'c';
        $field3->type = 'body';
        $field4 = new \stdclass();
        $field4->from = 'seo.translate_dictionary_source';
        $field4->keyword = 'd';
        $field4->result = 'd';
        $field4->type = 'body';
        $field5 = new \stdclass();
        $field5->from = 'seo.translate_dictionary_source';
        $field5->keyword = '>>>단위:cm';
        $field5->result = '>>>단위:cm';
        $field5->type = 'unit';
        $data = [[$field, $field2], [$field3, $field4], [$field5]];
        $args = json_encode(['count' => ['trados' => 0], 'data' => $data]);
        $expect = "a\tb".PHP_EOL."c\td".PHP_EOL.'>>>단위:cm';
        $this->assertSame($expect, $this->conv->toMatrix($args));
    }

    public function testCheckRowsFormat()
    {
        $this->assertFalse($this->conv->checkRowsFormat(''));
        $this->assertTrue($this->conv->checkRowsFormat([]));
        $this->assertFalse($this->conv->checkRowsFormat(['invalid format']));

        $field = new \stdclass();
        $field->from = 'invalid format';
        $field->keyword = '';
        $field->result = '';
        $field->type = '';
        $args = [$field];
        $this->assertFalse($this->conv->checkRowsFormat($args));

        $field = new \stdclass();
        $field->from = 'seo.translate_dictionary_source';
        $field->keyword = '';
        $field->result = '';
        $field->type = 'invalid format';
        $args = [$field];
        $this->assertFalse($this->conv->checkRowsFormat($args));

        $field = new \stdclass();
        $field->from = 'seo.translate_dictionary_source';
        $field->keyword = '';
        $field->result = '';
        $field->type = 'head';
        $args = [$field];
        $this->assertTrue($this->conv->checkRowsFormat($args));

        $field = new \stdclass();
        $field->from = 'seo.translate_dictionary_source';
        $field->keyword = '';
        $field->result = '';
        $field->type = 'head';
        $field2 = new \stdclass();
        $field2->from = 'seo.translate_dictionary_source';
        $field2->keyword = '';
        $field2->result = '';
        $field2->type = 'body';
        $field3 = new \stdclass();
        $field3->from = 'seo.translate_dictionary_source';
        $field3->keyword = '';
        $field3->result = '';
        $field3->type = 'unit';
        $args = [$field, $field2, $field3];
        $this->assertTrue($this->conv->checkRowsFormat($args));
    }
}
