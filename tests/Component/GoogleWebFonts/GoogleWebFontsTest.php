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

use Scribe\Teavee\GoogleWebFontsBundle\Components\GoogleWebFonts\GoogleWebFontsInterface;
use Scribe\WonkaBundle\Utility\TestCase\KernelTestCase;
use Scribe\Teavee\GoogleWebFontsBundle\Components\GoogleWebFonts\GoogleWebFonts;

/**
 * Class GoogleWebFontsTest.
 */
class GoogleWebFontsTest extends KernelTestCase
{
    /**
     * @var GoogleWebFonts
     */
    protected $generator;

    public function setUp()
    {
        parent::setUp();

        $this->generator = static::$staticContainer->get('s.teavee_google_web_fonts.generator');
    }

    public function test_get_link_template()
    {
        static::assertEquals(
            '<link rel="stylesheet" href="//fonts.googleapis.com/css?family=%FONTS%" />',
            $this->generator->getLinkTemplate()
        );
    }

    public function test_set_link_template()
    {
        $original = $this->generator->getLinkTemplate();
        $new = '<link rel="stylesheet" href=\'https://idk.something.com=%FONTS%\' rel=\'stylesheet\' type=\'text/css\'>';

        $this->generator->setLinkTemplate($new);
        static::assertEquals(
            $new,
            $this->generator->getLinkTemplate()
        );

        $this->generator->setLinkTemplate($original);
        static::assertEquals(
            $original,
            $this->generator->getLinkTemplate()
        );
    }

    public function test_reset_fonts()
    {
        static::assertNotEmpty($this->generator->getFonts());

        $this->generator->resetFonts();

        static::assertEmpty($this->generator->getFonts());
    }

    public function test_set_fonts()
    {
        $this->generator->resetFonts();
        $this->generator->setFonts([
            'Roboto' => [
                'weights' => [
                    GoogleWebFonts::WEIGHT_THIN,
                    GoogleWebFonts::WEIGHT_LIGHT,
                    GoogleWebFonts::WEIGHT_NORMAL,
                    GoogleWebFonts::WEIGHT_BOLD,
                    GoogleWebFonts::WEIGHT_EXTRA_BOLD,
                    GoogleWebFonts::WEIGHT_ULTRA_BOLD,
                ],
                'styles' => [
                    GoogleWebFonts::STYLE_NONE,
                    GoogleWebFonts::STYLE_ITALIC
                ]
            ],
            'Roboto Slab' => [
                'weights' => [
                    GoogleWebFonts::WEIGHT_THIN,
                    GoogleWebFonts::WEIGHT_NORMAL,
                    GoogleWebFonts::WEIGHT_BOLD,
                ],
                'styles' => [
                    GoogleWebFonts::STYLE_ITALIC
                ]
            ],
            'Roboto Foo' => [
                'weights' => [
                    GoogleWebFonts::WEIGHT_NORMAL,
                    GoogleWebFonts::WEIGHT_BOLD,
                ],
                'styles' => [
                    GoogleWebFonts::STYLE_NONE
                ]
            ]
        ]);

        static::assertEquals(
            [
                'Roboto' => [
                    '100',
                    '100italic',
                    '300',
                    '300italic',
                    '400',
                    '400italic',
                    '700',
                    '700italic',
                    '800',
                    '800italic',
                    '900',
                    '900italic',
                ],
                'Roboto Slab' => [
                    '100italic',
                    '400italic',
                    '700italic',
                ],
                'Roboto Foo' => [
                    '400',
                    '700',
                ]
            ],
            $this->generator->getFonts()
        );
    }

    public function test_add_font()
    {
        $this->generator->resetFonts();
        $this->generator->addFont('Roboto');

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL]],
            $this->generator->getFonts()
        );

        $this->generator->resetFonts();
        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_EXTRA_BOLD);

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_EXTRA_BOLD]],
            $this->generator->getFonts()
        );

        $this->generator->resetFonts();
        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_EXTRA_BOLD, GoogleWebFonts::STYLE_ITALIC);

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_EXTRA_BOLD . GoogleWebFonts::STYLE_ITALIC]],
            $this->generator->getFonts()
        );

        $this->generator->resetFonts();
        $this->generator->addFont('Roboto', null, GoogleWebFonts::STYLE_ITALIC);

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL . GoogleWebFonts::STYLE_ITALIC]],
            $this->generator->getFonts()
        );
    }

    public function test_add_font_with_attributes()
    {
        $this->generator->resetFonts();
        $this->generator->addFontWithAttributes('Roboto');

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL]],
            $this->generator->getFonts()
        );

        $this->generator->resetFonts();
        $this->generator->addFontWithAttributes('Roboto', [GoogleWebFonts::WEIGHT_EXTRA_BOLD]);

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_EXTRA_BOLD]],
            $this->generator->getFonts()
        );

        $this->generator->resetFonts();
        $this->generator->addFontWithAttributes('Roboto', [GoogleWebFonts::WEIGHT_EXTRA_BOLD], [GoogleWebFonts::STYLE_ITALIC]);

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_EXTRA_BOLD . GoogleWebFonts::STYLE_ITALIC]],
            $this->generator->getFonts()
        );

        $this->generator->resetFonts();
        $this->generator->addFontWithAttributes('Roboto', null, [GoogleWebFonts::STYLE_ITALIC]);

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL . GoogleWebFonts::STYLE_ITALIC]],
            $this->generator->getFonts()
        );
    }

    public function test_add_font_same_disallow_duplicates()
    {
        $this->generator->resetFonts();
        $this->generator->addFont('Roboto');

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL]],
            $this->generator->getFonts()
        );

        $this->generator->addFont('Roboto');
        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL]],
            $this->generator->getFonts()
        );

        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN);
        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL, GoogleWebFonts::WEIGHT_THIN]],
            $this->generator->getFonts()
        );

        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN);
        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL, GoogleWebFonts::WEIGHT_THIN]],
            $this->generator->getFonts()
        );

        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN, GoogleWebFonts::STYLE_ITALIC);
        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL, GoogleWebFonts::WEIGHT_THIN, GoogleWebFonts::WEIGHT_THIN.GoogleWebFonts::STYLE_ITALIC]],
            $this->generator->getFonts()
        );

        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN, GoogleWebFonts::STYLE_ITALIC);
        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL, GoogleWebFonts::WEIGHT_THIN, GoogleWebFonts::WEIGHT_THIN.GoogleWebFonts::STYLE_ITALIC]],
            $this->generator->getFonts()
        );
    }

    public function test_remove_font()
    {
        $this->generator->resetFonts();
        $this->generator->addFont('Roboto');

        $this->assertEquals(
            ['Roboto' => [GoogleWebFonts::WEIGHT_NORMAL]],
            $this->generator->getFonts()
        );

        $this->generator->removeFont('Roboto');

        $this->assertEquals(
            [],
            $this->generator->getFonts()
        );

        $this->generator->addFont('Roboto');
        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN);
        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN, GoogleWebFonts::STYLE_ITALIC);
        $this->generator->addFont('Roboto', null, GoogleWebFonts::STYLE_ITALIC);

        $this->assertEquals(
            [
                'Roboto' => [
                    GoogleWebFonts::WEIGHT_NORMAL,
                    GoogleWebFonts::WEIGHT_THIN,
                    GoogleWebFonts::WEIGHT_THIN . GoogleWebFonts::STYLE_ITALIC,
                    GoogleWebFonts::WEIGHT_NORMAL . GoogleWebFonts::STYLE_ITALIC,
                ]
            ],
            $this->generator->getFonts()
        );

        $this->generator->removeFont('Roboto');

        $this->assertEquals(
            [
                'Roboto' => [
                    GoogleWebFonts::WEIGHT_THIN,
                    GoogleWebFonts::WEIGHT_THIN . GoogleWebFonts::STYLE_ITALIC,
                    GoogleWebFonts::WEIGHT_NORMAL . GoogleWebFonts::STYLE_ITALIC,
                ]
            ],
            $this->generator->getFonts()
        );

        $this->generator->removeFont('Roboto', GoogleWebFonts::WEIGHT_THIN, GoogleWebFonts::STYLE_ITALIC);

        $this->assertEquals(
            [
                'Roboto' => [
                    GoogleWebFonts::WEIGHT_THIN,
                    GoogleWebFonts::WEIGHT_NORMAL . GoogleWebFonts::STYLE_ITALIC,
                ]
            ],
            $this->generator->getFonts()
        );
    }

    public function test_render_link()
    {
        $this->generator->resetFonts();
        $this->generator->addFont('Roboto');
        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN);
        $this->generator->addFont('Roboto', GoogleWebFonts::WEIGHT_THIN, GoogleWebFonts::STYLE_ITALIC);
        $this->generator->addFont('Roboto', null, GoogleWebFonts::STYLE_ITALIC);
        $this->generator->addFont('Roboto Slab', GoogleWebFonts::WEIGHT_ULTRA_BOLD);

        $this->assertEquals(
            '<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,400italic|Roboto+Slab:900" />',
            $this->generator->getStylesheetLink()
        );

        $this->generator->resetFonts();

        $this->assertEquals(
            null,
            $this->generator->getStylesheetLink()
        );
    }
}

/* EOF */
