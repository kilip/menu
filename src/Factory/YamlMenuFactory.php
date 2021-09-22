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

use Doyo\Menu\Contracts\MenuItemInterface;
use Doyo\Menu\MenuItem;
use Symfony\Component\Yaml\Yaml;

class YamlMenuFactory
{
    /**
     * @return array<array-key, MenuItemInterface>
     */
    public function fromYaml(string $yaml): array
    {
        /** @var array<array-key,array<array-key,string>> $parsed */
        $parsed = Yaml::parse($yaml);
        $menus  = [];

        foreach ($parsed as $item) {
            $menus[] = $this->parseMenuItem($item);
        }

        return $menus;
    }

    /**
     * @param array<array-key,string> $item
     */
    private function parseMenuItem(array $item): MenuItemInterface
    {
        $name  = $item['name'];
        $url   = $item['url'];
        $icon  = $item['icon'] ?? null;
        $label = $item['label'] ?? null;
        $menu  = new MenuItem(
            $name,
            $url,
            $label,
            $icon
        );

        if (\array_key_exists('meta', $item)) {
            /** @var array<array-key,scalar> $meta */
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
    private function parseChildren(MenuItem $menu, array $children): void
    {
        foreach ($children as $item) {
            $child = $this->parseMenuItem($item);
            $menu->addChildren($child);
        }
    }

    /**
     * @param array<array-key,scalar> $meta
     */
    private function parseMeta(MenuItem $menu, array $meta): void
    {
        foreach ($meta as $name => $value) {
            /* @var string $name */
            $menu->addMeta($name, $value);
        }
    }
}
