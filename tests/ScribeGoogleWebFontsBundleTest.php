<?php

/*
 * This file is part of the Scribe Cache Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 * (c) Matthias Noback <
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Teavee\GoogleWebFontsBundle\Tests;

use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ScribeGoogleWebFontsBundleTest.
 */
class ScribeGoogleWebFontsBundleTest extends WonkaTestCase
{
    /**
     * @var \AppKernel
     */
    static $kernel;

    public function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        self::$kernel = $kernel;
    }

    public function tearDown()
    {
        self::$kernel->shutdown();
    }

    public function test_kernel_build_container()
    {
        static::assertInstanceOf('Symfony\Component\DependencyInjection\ContainerInterface', self::$kernel->getContainer());
    }

    public function test_has_google_web_font_generator_service()
    {
        static::assertTrue(self::$kernel->getContainer()->has('s.google_web_fonts.generator'));
    }

    public function test_has_google_web_font_extension_service()
    {
        static::assertTrue(self::$kernel->getContainer()->has('s.google_web_fonts.twig_extension'));
    }
}

/* EOF */
