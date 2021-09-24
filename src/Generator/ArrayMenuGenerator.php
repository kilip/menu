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

namespace Doyo\Menu\Generator;

use Doyo\Menu\Contracts\MenuGeneratorInteface;
use Doyo\Menu\Contracts\MenuInterface;
use Doyo\Menu\Menu;

class ArrayMenuGenerator implements MenuGeneratorInteface
{
    /**
     * @var class-string
     */
    protected string $menuClass;

    /**
     * @var MenuInterface[]
     */
    protected array $menus = [];

    /**
     * @param class-string $menuClass
     */
    public function __construct(
        string $menuClass = Menu::class
    ) {
        $this->menuClass = $menuClass;
    }

    /**
     * @param array<array-key,array<array-key,string>> $definitions
     */
    public function generateMenus(array $definitions): void
    {
        $menus  = [];

        foreach ($definitions as $item) {
            $menu = $this->parseMenuItem($item);
            if (null !== $menu) {
                $menus[] = $menu;
            }
        }

        $this->menus = $menus;
    }

    public function getMenus(): array
    {
        return $this->menus;
    }

    /**
     * @param array<array-key,string> $item
     * @psalm-suppress MixedMethodCall
     */
    protected function parseMenuItem(array $item): ?MenuInterface
    {
        $menuClass = $this->menuClass;
        $name      = $item['name'];
        $url       = $item['url'];
        $icon      = $item['icon'] ?? null;
        $label     = $item['label'] ?? null;
        /** @var MenuInterface $menu */
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
        if (\array_key_exists('subMenus', $item)) {
            /** @var array<array-key,array<array-key,string>> $children */
            $children = $item['subMenus'];
            $this->parseSubMenus($menu, $children);
        }

        return $menu;
    }

    /**
     * @param array<array-key, array<array-key,string>> $subMenus
     */
    protected function parseSubMenus(MenuInterface $menu, array $subMenus): void
    {
        foreach ($subMenus as $item) {
            $child = $this->parseMenuItem($item);
            if (null !== $child) {
                $menu->addSubMenu($child);
            }
        }
    }

    /**
     * @param array<string,scalar> $meta
     */
    protected function parseMeta(MenuInterface $menu, array $meta): void
    {
        foreach ($meta as $name => $value) {
            $menu->addMeta($name, $value);
        }
    }
}
