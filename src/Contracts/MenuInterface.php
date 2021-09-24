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

namespace Doyo\Menu\Contracts;

use Doctrine\Common\Collections\Collection;

interface MenuInterface
{
    public function setName(string $name): void;

    public function getName(): string;

    public function setLabel(string $label): void;

    public function getLabel(): string;

    public function setIcon(string $icon): void;

    public function getIcon(): ?string;

    public function setUrl(string $url): void;

    public function getUrl(): string;

    /**
     * @return scalar|array<array-key,scalar>|null
     */
    public function getMeta(string $name=null);

    /**
     * @param array<array-key,scalar> $meta
     */
    public function setMeta(array $meta): void;

    /**
     * @param scalar $value
     */
    public function addMeta(string $name, $value): void;

    public function hasMeta(string $name): bool;

    public function getSubMenus(): Collection;

    public function setSubMenus(Collection $subMenus): void;

    public function addSubMenu(self $subMenu): void;

    public function removeSubMenu(self $subMenu): void;

    public function hasSubMenu(self $subMenu): bool;
}
