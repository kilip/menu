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

interface MetaInterface
{
    public function setName(string $name): void;

    public function getName(): string;

    /**
     * @param mixed|string|bool|int $value
     */
    public function setValue($value): void;

    /**
     * @return mixed|string|bool|int
     */
    public function getValue();
}
