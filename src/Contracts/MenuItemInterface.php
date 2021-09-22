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

interface MenuItemInterface
{
    public function setName(string $name): void;

    public function getName(): string;

    public function setLabel(string $label): void;

    public function getLabel(): string;

    public function setIcon(string $icon): void;

    public function getIcon(): string;

    public function setUrl(string $url): void;

    public function getUrl(): string;

    /**
     * @return array<array-key, MetaInterface>
     */
    public function getMetas(): array;

    /**
     * @param array<array-key, MetaInterface> $metas
     */
    public function setMetas(array $metas): void;

    public function addMeta(MetaInterface $meta): void;
}
