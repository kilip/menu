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

namespace Doyo\Menu;

use Doyo\Menu\Contracts\MenuItemInterface;

class MenuItem implements MenuItemInterface
{
    private string $name;

    private string $url;

    private string $label;

    private ?string $icon;

    /**
     * @var array<array-key,scalar>
     */
    private array $meta;

    /**
     * @var array<array-key, MenuItemInterface>
     */
    private array $children = [];

    /**
     * @param array<array-key,scalar> $meta
     */
    public function __construct(
        string $name,
        string $url,
        string $label = null,
        string $icon = null,
        array $meta = []
    ) {
        if (null === $label) {
            $label = $name;
        }

        $this->name  = $name;
        $this->url   = $url;
        $this->label = $label;
        $this->icon  = $icon;
        $this->meta  = $meta;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function setChildren(array $children): void
    {
        $this->children = $children;
    }

    public function addChildren(MenuItemInterface $child): void
    {
        $this->children[] = $child;
    }

    public function addMeta(string $name, $value): void
    {
        $this->meta[$name] = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }
}
