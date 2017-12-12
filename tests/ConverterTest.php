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

namespace MatrixConverter\Test;

use PHPUnit\Framework\TestCase;
use MatrixConverter\Converter;

/**
 * Test class for Converter.
 *
 * @coversNothing
 */
class ConverterTest extends TestCase
{
    public function setUp()
    {
        $this->conv = new Converter();
    }

    public function testMissingArgument()
    {
        $this->expectException(\PHPUnit\Framework\Error\Error::class);
        $this->conv->toJsonMatrix();
    }

    public function testJsonToTabMatrixMissingArgument()
    {
        $this->expectException(\PHPUnit\Framework\Error\Error::class);
        $this->conv->toTabMatrix();
    }

    public function testInvalidArgumentException()
    {
        $this->assertTrue($this->assertToJsonMatrixInvalidArgument(null));
        $this->assertTrue($this->assertToJsonMatrixInvalidArgument(''));
        $this->assertTrue($this->assertToJsonMatrixInvalidArgument(0));
        $this->assertTrue($this->assertToJsonMatrixInvalidArgument(1));
        $this->assertTrue($this->assertToJsonMatrixInvalidArgument([]));

        $this->assertTrue($this->assertToTabMatrixInvalidArgument(null));
        $this->assertTrue($this->assertToTabMatrixInvalidArgument(''));
        $this->assertTrue($this->assertToTabMatrixInvalidArgument(0));
        $this->assertTrue($this->assertToTabMatrixInvalidArgument(1));
        $this->assertTrue($this->assertToTabMatrixInvalidArgument([]));
    }

    public function testTabMatrixToJsonMatrix()
    {
        $this->assertSame($this->getExpect('a'), $this->conv->toJsonMatrix('a'));
        $this->assertSame($this->getExpect("a\tb"), $this->conv->toJsonMatrix("a\tb"));
        $string = <<<'DOC'
a	b
c	d
DOC;
        $result = $this->conv->toJsonMatrix($string);
        $expect = [
            'count' => [
                'trados' => 0,
            ],
            'data' => [
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'a',
                        'result' => 'a',
                        'type' => 'head',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'b',
                        'result' => 'b',
                        'type' => 'head',
                    ],
                ],
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'c',
                        'result' => 'c',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'd',
                        'result' => 'd',
                        'type' => 'body',
                    ],
                ],
            ],
        ];
        $expect = json_encode($expect);
        $this->assertSame($expect, $result);

        $string = <<<'DOC'
a	b
c	d
e	f	g	h
DOC;
        $result = $this->conv->toJsonMatrix($string);
        $expect = [
            'count' => [
                'trados' => 0,
            ],
            'data' => [
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'a',
                        'result' => 'a',
                        'type' => 'head',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'b',
                        'result' => 'b',
                        'type' => 'head',
                    ],
                ],
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'c',
                        'result' => 'c',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'd',
                        'result' => 'd',
                        'type' => 'body',
                    ],
                ],
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'e',
                        'result' => 'e',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'f',
                        'result' => 'f',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'g',
                        'result' => 'g',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'h',
                        'result' => 'h',
                        'type' => 'body',
                    ],
                ],
            ],
        ];
        $expect = json_encode($expect);
        $this->assertSame($expect, $result);
    }

    public function testUnitStringToJson()
    {
        $string = <<<'DOC'
a	b
c	d
e	f	g	h
>>>단위:cm
DOC;
        $result = $this->conv->toJsonMatrix($string);
        $expect = [
            'count' => [
                'trados' => 0,
            ],
            'data' => [
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'a',
                        'result' => 'a',
                        'type' => 'head',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'b',
                        'result' => 'b',
                        'type' => 'head',
                    ],
                ],
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'c',
                        'result' => 'c',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'd',
                        'result' => 'd',
                        'type' => 'body',
                    ],
                ],
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'e',
                        'result' => 'e',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'f',
                        'result' => 'f',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'g',
                        'result' => 'g',
                        'type' => 'body',
                    ],
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => 'h',
                        'result' => 'h',
                        'type' => 'body',
                    ],
                ],
                [
                    [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => '>>>단위:cm',
                        'result' => '>>>단위:cm',
                        'type' => 'unit',
                    ],
                ],
            ],
        ];
        $expect = json_encode($expect);
        $this->assertSame($expect, $result);
    }

    public function getExpect($text)
    {
        $split = explode("\t", (string) $text);
        $heads = [];
        foreach ($split as $token) {
            $head = [
                'from' => 'seo.translate_dictionary_source',
                'keyword' => $token,
                'result' => $token,
                'type' => 'head',
            ];
            $heads[] = $head;
        }

        $result = [
            'count' => ['trados' => 0],
            'data' => [
                $heads,
            ],
        ];
        $result = json_encode($result);

        return $result;
    }

    private function assertToJsonMatrixInvalidArgument($argu)
    {
        try {
            $this->conv->toJsonMatrix($argu);

            return false;
        } catch (\InvalidArgumentException $e) {
            return true;
        }
    }

    private function assertToTabMatrixInvalidArgument($argu)
    {
        try {
            $this->conv->toTabMatrix($argu);

            return false;
        } catch (\InvalidArgumentException $e) {
            return true;
        }
    }
}
