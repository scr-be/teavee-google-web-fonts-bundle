<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Teavee\GoogleWebFontsBundle\Templating\Extension;

use Scribe\Teavee\GoogleWebFontsBundle\Components\GoogleWebFonts\GoogleWebFontsInterface;
use Scribe\WonkaBundle\Component\Templating\AbstractTwigExtension;

/**
 * Class GoogleWebFontsExtension.
 */
class GoogleWebFontsExtension extends AbstractTwigExtension
{
    /**
     * @var GoogleWebFontsInterface
     */
    private $generator;

    /**
     * @param GoogleWebFontsInterface $webFonts
     */
    public function __construct(GoogleWebFontsInterface $webFonts)
    {
        parent::__construct();

        $this->generator = $webFonts;

        $this
            ->enableOptionHtmlSafe()
            ->addFunction('add_font',      [$this, 'addFont']    )
            ->addFunction('get_font_link', [$this, 'getFontStylesheetLink']);
    }

    /**
     * @return GoogleWebFontsInterface
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @param string      $font
     * @param int|null    $weight
     * @param string|null $style
     *
     * @return $this
     */
    public function addFont($font, $weight = null, $style = null)
    {
        $this->generator->addFont($font, $weight, $style);

        return $this;
    }

    /**
     * @return string
     */
    public function getFontStylesheetLink()
    {
        return $this->generator->getStylesheetLink();
    }
}

/* EOF */
