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

namespace Doyo\Menu\Bridge\Symfony\Exception;

class MenuException extends \Exception
{
    public static function configDirNotExists(string $configDir): self
    {
        return new self(sprintf(
            'Menu config dir "%s" not exists.',
            $configDir
        ));
    }
}
