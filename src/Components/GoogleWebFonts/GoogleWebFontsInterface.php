<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Teavee\GoogleWebFontsBundle\Components\GoogleWebFonts;

/**
 * Interface GoogleWebFontsInterface.
 */
interface GoogleWebFontsInterface
{
    /**
     * @var int
     */
    const WEIGHT_THIN = 100;

    /**
     * @var int
     */
    const WEIGHT_LIGHT = 300;

    /**
     * @var int
     */
    const WEIGHT_NORMAL = 400;

    /**
     * @var int
     */
    const WEIGHT_MEDIUM = 500;

    /**
     * @var int
     */
    const WEIGHT_BOLD = 700;

    /**
     * @var int
     */
    const WEIGHT_EXTRA_BOLD = 800;

    /**
     * @var int
     */
    const WEIGHT_ULTRA_BOLD = 900;

    /**
     * @var string
     */
    const STYLE_NONE = 'normal';

    /**
     * @var string
     */
    const STYLE_ITALIC = 'italic';

    /**
     * @param string $linkTemplate
     *
     * @return $this
     */
    public function setLinkTemplate($linkTemplate);

    /**
     * @return string
     */
    public function getLinkTemplate();

    /**
     * @param array[] $fonts
     *
     * @return $this
     */
    public function setFonts(array $fonts = []);

    /**
     * @return array[]
     */
    public function getFonts();

    /**
     * @return $this
     */
    public function resetFonts();

    /**
     * @param string      $name
     * @param int|null    $weight
     * @param string|null $style
     *
     * @return $this
     */
    public function addFont($name, $weight = null, $style = null);

    /**
     * @param string     $name
     * @param array|null $weights
     * @param array|null $styles
     *
     * @return $this
     */
    public function addFontWithAttributes($name, array $weights = null, array $styles = null);

    /**
     * @param string      $name
     * @param int|null    $weight
     * @param string|null $style
     *
     * @return $this
     */
    public function removeFont($name, $weight = null, $style = null);

    /**
     * @return string
     */
    public function getStylesheetLink();
}

/* EOF */
