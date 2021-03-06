<?php

/*
 * This file is part of the MultiPartParser package.
 *
 * (c) Romain Cambien <romain@cambien.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Riverline\MultiPartParser\Converters;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class HttpFoundationTest
 */
class HttpFoundationTest extends Commun
{
    /**
     * Test the parser
     */
    public function testParser()
    {
        $request = Request::create(
            '/',
            'GET',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'multipart/form-data; boundary=----------------------------83ff53821b7c'],
            $this->createBodyStream()
        );

        // Test the converter
        $part = HttpFoundation::convert($request);

        self::assertTrue($part->isMultiPart());
        self::assertCount(3, $part->getParts());

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage("MultiPart content, there aren't body");
        $part->getBody();
    }
}
