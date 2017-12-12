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

trait ConverterCommonTestFunctions
{
    public function testMissingArgument()
    {
        $this->expectException(\PHPUnit\Framework\Error\Error::class);
        $this->conv->toMatrix();
    }

    public function testInvalidArgumentException()
    {
        $this->assertTrue($this->assertToMatrixInvalidArgument(null));
        $this->assertTrue($this->assertToMatrixInvalidArgument(''));
        $this->assertTrue($this->assertToMatrixInvalidArgument(0));
        $this->assertTrue($this->assertToMatrixInvalidArgument(1));
        $this->assertTrue($this->assertToMatrixInvalidArgument([]));
    }

    private function assertToMatrixInvalidArgument($argu)
    {
        try {
            $this->conv->toMatrix($argu);

            return false;
        } catch (\InvalidArgumentException $e) {
            return true;
        }
    }
}
