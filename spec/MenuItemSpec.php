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

namespace spec\Doyo\Menu;

use Doyo\Menu\Contracts\MenuItemInterface;
use Doyo\Menu\MenuItem;
use PhpSpec\ObjectBehavior;

class MenuItemSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(
            'name',
            '/url'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MenuItem::class);
    }

    public function it_should_implement_menu_item_interface()
    {
        $this->shouldImplement(MenuItemInterface::class);
    }
}
