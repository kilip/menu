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

namespace Doyo\Menu\Exception;

use Doyo\Menu\Contracts\MenuInterface;

class MenuException extends \Exception
{
    public static function menuAlreadyExists(MenuInterface $menu): self
    {
        return new self(sprintf(
            'Sub menu named "%s" already exists.',
            $menu->getName()
        ));
    }
}
