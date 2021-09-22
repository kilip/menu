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

interface MenuFactory
{
    /**
     * @param array<array-key,array<array-key,string>> $definitions
     *
     * @return MenuItemInterface[]
     */
    public function generateMenus(array $definitions): array;
}
