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

use Doyo\Menu\Contracts\MetaInterface;

class Meta implements MetaInterface
{
    private string $name;

    /**
     * @var bool|int|string|float|scalar
     */
    private $value;

    /**
     * @param bool|int|string|float|scalar $value
     */
    public function __construct(string $name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool|int|string|float|scalar
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
