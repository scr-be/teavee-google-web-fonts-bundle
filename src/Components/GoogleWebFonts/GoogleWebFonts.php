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
 * Class GoogleWebFonts.
 */
class GoogleWebFonts implements GoogleWebFontsInterface
{
    /**
     * @var array[]
     */
    protected $fonts = [];

    /**
     * @var string
     */
    protected $linkTemplate = '<link rel="stylesheet" href="//fonts.googleapis.com/css?family=%FONTS%">';

    /**
     * @param array[] $fonts
     */
    public function __construct(array $fonts = [])
    {
        $this->setFonts($fonts);

        return $this;
    }

    /**
     * @param string $linkTemplate
     *
     * @return $this
     */
    public function setLinkTemplate($linkTemplate)
    {
        $this->linkTemplate = (string) $linkTemplate;

        return $this;
    }

    /**
     * @return string
     */
    public function getLinkTemplate()
    {
        return $this->linkTemplate;
    }

    /**
     * @param array[] $fonts
     *
     * @return $this
     */
    public function setFonts(array $fonts = [])
    {
        foreach ($fonts as $name => $attributes) {
            $this->addFontWithAttributes($name, $attributes['weights'], $attributes['styles']);
        }

        return $this;
    }

    /**
     * @return array[]
     */
    public function getFonts()
    {
        return $this->fonts;
    }

    /**
     * @return $this
     */
    public function resetFonts()
    {
        $this->fonts = [];

        return $this;
    }

    /**
     * @param string      $name
     * @param int|null    $weight
     * @param string|null $style
     *
     * @return $this
     */
    public function addFont($name, $weight = null, $style = null)
    {
        list($weight) = $this->normalizeWeights([$weight]);
        list($style) = $this->normalizeStyles([$style]);
        $attribute = $this->normalizeAttributes($weight, $style);

        if (!(array_key_exists((string) $name, $this->fonts) && false !== array_search($attribute, $this->fonts[(string) $name]))) {
            $this->fonts[(string) $name][] = $attribute;
        }

        return $this;
    }

    /**
     * @param string     $name
     * @param array|null $weights
     * @param array|null $styles
     *
     * @return $this
     */
    public function addFontWithAttributes($name, array $weights = null, array $styles = null)
    {
        $weights = $this->normalizeWeights($weights);
        $styles = $this->normalizeStyles($styles);

        foreach ($weights as $weight) {
            array_map(function ($style) use ($name, $weight) {
                $this->addFont($name, $weight, $style);
            }, $styles);
        }

        return $this;
    }

    /**
     * @param string      $name
     * @param int|null    $weight
     * @param string|null $style
     *
     * @return $this
     */
    public function removeFont($name, $weight = null, $style = null)
    {
        list($weight) = $this->normalizeWeights([$weight]);
        list($style) = $this->normalizeStyles([$style]);
        $attribute = $this->normalizeAttributes($weight, $style);

        if (array_key_exists((string) $name, $this->fonts) && false !== ($index = array_search($attribute, $this->fonts[(string) $name]))) {
            unset($this->fonts[$name][$index]);

            if (count($this->fonts[$name]) === 0) {
                unset($this->fonts[$name]);
            } else {
                $this->fonts[$name] = array_values($this->fonts[$name]);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStylesheetLink()
    {
        if (count($this->fonts) > 0) {
            return str_replace('%FONTS%', $this->renderStylesheetLinkFonts(), $this->linkTemplate);
        }

        return;
    }

    /**
     * @return string
     */
    protected function renderStylesheetLinkFonts()
    {
        $fonts = [];

        foreach ($this->fonts as $name => $weights) {
            $fonts[] = urlencode($name).':'.implode(',', $weights);
        }

        return implode('|', $fonts);
    }

    /**
     * @param int[]|null $weights
     *
     * @return int[]
     */
    protected function normalizeWeights($weights)
    {
        $weights = is_array($weights) ? $weights : [$weights];

        array_walk($weights, function (&$w) {
            if (null === $w) {
                $w = self::WEIGHT_NORMAL;
            }

            $w = (int) $w;
        });

        return (array) $weights;
    }

    /**
     * @param string[]|null $styles
     *
     * @return string[]
     */
    protected function normalizeStyles($styles)
    {
        $styles = is_array($styles) ? $styles : [$styles];

        array_walk($styles, function (&$s) {
            if (null === $s) {
                $s = self::STYLE_NONE;
            }

            $s = (string) $s;
        });

        return (array) $styles;
    }

    /**
     * @param int|null    $weight
     * @param string|null $style
     *
     * @return string
     */
    protected function normalizeAttributes($weight, $style)
    {
        return (string) ((int) $weight.(string) ($style != self::STYLE_NONE ? $style : ''));
    }
}

/* EOF */
