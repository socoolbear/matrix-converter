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

namespace MatrixConverter;

class TabConverter implements IConverter
{
    public function toMatrix($text)
    {
        if (empty($text) or is_int($text) or empty(json_decode($text))) {
            throw new \InvalidArgumentException();
        }

        $matrix = json_decode($text);

        if (!isset($matrix->count->trados) or !is_int($matrix->count->trados)
            or $matrix->count->trados < 0) {
            throw new \InvalidArgumentException('Not expected JosnFormat - count field.');
        }

        if (!isset($matrix->data) or !is_array($matrix->data)) {
            throw new \InvalidArgumentException('Not expected JosnFormat - data field.');
        }

        if (empty($matrix->data)) {
            return '';
        }

        $results = [];
        foreach ($matrix->data as $idx => $rows) {
            if (0 === $idx) {
                if (!isset($rows[0]->type) or 'head' !== $rows[0]->type) {
                    throw new \InvalidArgumentException('Not expected JosnFormat - data field.');
                }
            }
            if (!$this->checkRowsFormat($rows)) {
                throw new \InvalidArgumentException('Not expected JosnFormat - data field.');
            }

            $fields = [];
            for ($i = 0; $i < count($rows); ++$i) {
                $fields[] = $rows[$i]->result;
            }
            $result[] = implode("\t", $fields);
        }

        return implode(PHP_EOL, $result);
    }

    public function checkRowsFormat($rows)
    {
        if (!is_array($rows)) {
            return false;
        }

        foreach ($rows as $field) {
            if (!isset($field->from) or !isset($field->keyword)
                or !isset($field->result) or !isset($field->type)) {
                return false;
            }
            if ('seo.translate_dictionary_source' !== $field->from) {
                return false;
            }

            if (!in_array($field->type, ['head', 'body', 'unit'], true)) {
                return false;
            }
        }

        return true;
    }
}
