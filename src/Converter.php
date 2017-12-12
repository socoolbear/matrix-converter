<?php

/*
 * This file is part of Matrix Converter Library.
 *
 * (c) Kim Bong Yeon <bykim02@cafe24corp.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

/*
 * This file is part of this package.
 *
 * (c) SoCoolBear <socoolbear@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MatrixConverter;

class Converter
{
    public function toTabMatrix($text)
    {
        if (empty($text) or !is_string($text)) {
            throw new \InvalidArgumentException();
        }
    }

    public function toJsonMatrix($text)
    {
        if (empty($text) or !is_string($text)) {
            throw new \InvalidArgumentException();
        }
        $text = (string) $text;
        $lines = explode(PHP_EOL, $text);
        $rows = [];
        foreach ($lines as $line) {
            $split = explode("\t", $line);
            $rows[] = $split;
        }

        $heads = [];
        $bodies = [];
        $type = 'body';
        foreach ($rows as $key => $row) {
            if (0 === $key) {
                foreach ($row as $token) {
                    $head = [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => $token,
                        'result' => $token,
                        'type' => 'head',
                    ];
                    $heads[] = $head;
                }
            }

            if ($key > 0) {
                $bodys = [];
                foreach ($row as $token) {
                    !(0 === strpos($token, '>>>')) ?: $type = 'unit';
                    $body = [
                        'from' => 'seo.translate_dictionary_source',
                        'keyword' => $token,
                        'result' => $token,
                        'type' => $type,
                    ];
                    $bodys[] = $body;
                }
                $bodies[] = $bodys;
            }
        }

        array_unshift($bodies, $heads);

        $result = [
            'count' => ['trados' => 0],
            'data' => $bodies,
        ];
        $result = json_encode($result);

        return $result;
    }
}
