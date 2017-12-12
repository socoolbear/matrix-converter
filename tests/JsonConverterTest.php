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

namespace MatrixConverter\Tests;

use PHPUnit\Framework\TestCase;
use MatrixConverter\JsonConverter;

/**
 * Test class for JsonConverter.
 *
 * @coversNothing
 */
class JsonConverterTest extends TestCase
{
    use ConverterCommonTestFunctions;

    public function setUp()
    {
        $this->conv = new JsonConverter();
    }

    public function testToMatrix()
    {
        $this->assertSame($this->getExpect('a'), $this->conv->toMatrix('a'));
        $this->assertSame($this->getExpect("a\tb"), $this->conv->toMatrix("a\tb"));
        $string = <<<'DOC'
a	b
c	d
DOC;
        $result = $this->conv->toMatrix($string);
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
        $result = $this->conv->toMatrix($string);
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

    public function testUnitStringtoMatrix()
    {
        $string = <<<'DOC'
a	b
c	d
e	f	g	h
>>>단위:cm
DOC;
        $result = $this->conv->toMatrix($string);
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

    private function getExpect($text)
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
}
