<?php

/*
 * This file is part of the DoyoLabs Menu project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Doyo\Menu\Factory;

use Doyo\Menu\Contracts\MenuFactory;
use Doyo\Menu\Contracts\MenuItemInterface;
use Doyo\Menu\MenuItem;

class ArrayMenuFactory implements MenuFactory
{
    /**
     * @var class-string
     */
    private string $menuClass;

    /**
     * @param class-string $menuClass
     */
    public function __construct(
        string $menuClass = MenuItem::class
    ) {
        $this->menuClass = $menuClass;
    }

    /**
     * {@inheritDoc}
     */
    public function generateMenus(array $definitions): array
    {
        $menus  = [];

        foreach ($definitions as $item) {
            $menus[] = $this->parseMenuItem($item);
        }

        return $menus;
    }

    /**
     * @param array<array-key,string> $item
     * @psalm-suppress MixedMethodCall
     */
    protected function parseMenuItem(array $item): MenuItemInterface
    {
        $menuClass = $this->menuClass;
        $name      = $item['name'];
        $url       = $item['url'];
        $icon      = $item['icon'] ?? null;
        $label     = $item['label'] ?? null;
        /** @var MenuItemInterface $menu */
        $menu  = new $menuClass(
            $name,
            $url,
            $label,
            $icon
        );

        if (\array_key_exists('meta', $item)) {
            /** @var array<string,scalar> $meta */
            $meta = $item['meta'];
            $this->parseMeta($menu, $meta);
        }
        if (\array_key_exists('children', $item)) {
            /** @var array<array-key,array<array-key,string>> $children */
            $children = $item['children'];
            $this->parseChildren($menu, $children);
        }

        return $menu;
    }

    /**
     * @param array<array-key, array<array-key,string>> $children
     */
    protected function parseChildren(MenuItemInterface $menu, array $children): void
    {
        foreach ($children as $item) {
            $child = $this->parseMenuItem($item);
            $menu->addChildren($child);
        }
    }

    /**
     * @param array<string,scalar> $meta
     */
    protected function parseMeta(MenuItemInterface $menu, array $meta): void
    {
        foreach ($meta as $name => $value) {
            $menu->addMeta($name, $value);
        }
    }
}
