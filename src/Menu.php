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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doyo\Menu\Contracts\MenuInterface;

class Menu implements MenuInterface
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
     * @var Collection|ArrayCollection
     * @psalm-var
     */
    private Collection $subMenus;

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

        $this->name     = $name;
        $this->url      = $url;
        $this->label    = $label;
        $this->icon     = $icon;
        $this->meta     = $meta;
        $this->subMenus = new ArrayCollection();
    }

    public function hasSubMenu(MenuInterface $subMenu): bool
    {
        return $this->subMenus->contains($subMenu);
    }

    public function removeSubMenu(MenuInterface $subMenu): void
    {
        if ($this->hasSubMenu($subMenu)) {
            $this->subMenus->removeElement($subMenu);
        }
    }

    public function getSubMenus(): Collection
    {
        return $this->subMenus;
    }

    public function setSubMenus(Collection $subMenus): void
    {
        $this->subMenus = $subMenus;
    }

    public function addSubMenu(MenuInterface $subMenu): void
    {
        if (false === $this->hasSubMenu($subMenu)) {
            $this->subMenus->add($subMenu);
        }
    }

    public function setMeta(array $meta): void
    {
        $this->meta = $meta;
    }

    public function hasMeta(string $name): bool
    {
        return \array_key_exists($name, $this->meta);
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

    /**
     * {@inheritDoc}
     */
    public function getMeta(string $name = null)
    {
        if (null === $name) {
            return $this->meta;
        }

        return $this->meta[$name];
    }
}
