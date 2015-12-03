<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Teavee\GoogleWebFontsBundle\Tests\Components\GoogleWebFonts;

use Scribe\Teavee\GoogleWebFontsBundle\Components\GoogleWebFonts\GoogleWebFonts;
use Scribe\WonkaBundle\Utility\TestCase\KernelTestCase;
use Scribe\Teavee\GoogleWebFontsBundle\Templating\Extension\GoogleWebFontsExtension;

/**
 * Class GoogleWebFontsTest.
 */
class GoogleWebFontsExtensionTest extends KernelTestCase
{
    /**
     * @var GoogleWebFontsExtension
     */
    protected $e;

    public function setUp()
    {
        parent::setUp();

        $this->e = static::$staticContainer->get('s.google_web_fonts.twig_extension');
    }

    public function test_empty_font_list()
    {
        $this->e->getGenerator()->resetFonts();

        static::assertEquals(
            null,
            $this->e->getFontStylesheetLink()
        );
    }

    public function test_get_link()
    {
        $g = $this->e->getGenerator();
        $g->resetFonts();
        $this->e->addFont('Roboto');
        $this->e->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN);
        $this->e->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN, GoogleWebFonts::STYLE_ITALIC);
        $this->e->addFont('Roboto', null, GoogleWebFonts::STYLE_ITALIC);
        $this->e->addFont('Roboto Slab', GoogleWebFonts::WEIGHT_ULTRA_BOLD);
        
        static::assertEquals(
            '<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,400italic|Roboto+Slab:900" />',
            $this->e->getFontStylesheetLink()
        );
    }
}

/* EOF */
