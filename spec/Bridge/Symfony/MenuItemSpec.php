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

namespace spec\Doyo\Menu\Bridge\Symfony;

use Doyo\Menu\Bridge\Symfony\MenuItem;
use PhpSpec\ObjectBehavior;

class MenuItemSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MenuItem::class);
    }
}
