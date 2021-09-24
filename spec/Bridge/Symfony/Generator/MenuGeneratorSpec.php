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

namespace spec\Doyo\Menu\Bridge\Symfony\Generator;

use Doyo\Menu\Bridge\Symfony\Generator\MenuGenerator;
use Doyo\Menu\Contracts\MenuGeneratorInteface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuGeneratorSpec extends ObjectBehavior
{
    public function let(
        AuthorizationCheckerInterface $authChecker,
        AdapterInterface $cacheAdapter
    ) {
        $this->beConstructedWith(
            $authChecker,
            $cacheAdapter,
            'some-dir'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MenuGenerator::class);
    }

    public function it_should_be_a_menu_factory()
    {
        $this->shouldImplement(MenuGeneratorInteface::class);
    }

    public function it_should_check_security_during_parse_menu()
    {
    }
}
