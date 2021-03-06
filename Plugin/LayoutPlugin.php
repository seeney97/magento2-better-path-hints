<?php

namespace MageRules\BetterPathHints\Plugin;

use Magento\Framework\View\Layout;
use MageRules\BetterPathHints\Model\Wrapper;

/**
 * Plugin class for @see \Magento\Framework\View\Layout
 */
class LayoutPlugin
{
    /**
     * @var Wrapper
     */
    private $wrapper;

    /**
     * LayoutPlugin constructor.
     * @param Wrapper $wrapper
     */
    public function __construct(
        Wrapper $wrapper
    ) {
        $this->wrapper = $wrapper;
    }

    /**
     * @param Layout $layout
     * @param callable $proceed
     * @param $name
     * @return string
     */
    public function aroundRenderNonCachedElement(Layout $layout, callable $proceed, $name)
    {
        $result = $proceed($name);
        if ($layout->isBlock($name)) {
            return $result;
        }
        return $this->wrapper->wrapHtml(
            $result,
            $layout->getElementProperty($name, 'type'),
            [
                'name'   => $name,
                'parent' => $layout->getParentName($name),
            ]
        );
    }
}
