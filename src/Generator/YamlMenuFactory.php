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

namespace Doyo\Menu\Generator;

use Symfony\Component\Yaml\Yaml;

class YamlMenuFactory extends ArrayMenuFactory
{
    public function fromYaml(string $yaml): void
    {
        /** @var array<array-key,array<array-key,string>> $parsed */
        $parsed = Yaml::parse($yaml);
        $this->generateMenus($parsed);
    }
}
