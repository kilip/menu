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

use Doctrine\Common\Collections\ArrayCollection;
use Doyo\Menu\Contracts\MenuInterface;
use Doyo\Menu\Menu;
use PhpSpec\ObjectBehavior;

class MenuSpec extends ObjectBehavior
{
    public function let(
        MenuInterface $menu
    ) {
        $menu->getName()->willReturn('menu');
        $this->beConstructedWith(
            'name',
            '/url'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Menu::class);
    }

    public function it_should_implement_menu_item_interface()
    {
        $this->shouldImplement(MenuInterface::class);
    }

    public function it_should_set_label_by_name()
    {
        $this->getLabel()->shouldReturn('name');
    }

    public function its_hasSubMenu_should_check_existing_menu(
        MenuInterface $menu
    ) {
        $this->hasSubMenu($menu)->shouldBe(false);
        $this->addSubMenu($menu);
        $this->hasSubMenu($menu)->shouldBe(true);
    }

    public function its_removeSubMenu_should_remove_sub_menu(
        MenuInterface $menu
    ) {
        $this->addSubMenu($menu);
        $this->hasSubMenu($menu)->shouldBe(true);
        $this->removeSubMenu($menu);
        $this->hasSubMenu($menu)->shouldBe(false);
    }

    public function its_getSubMenus_returns_all_submenus(
        MenuInterface $menu
    ) {
        $this->addSubMenu($menu);

        $this->getSubMenus()->shouldContain($menu);
    }

    public function its_setSubMenus_should_set_menus(
        MenuInterface $menu
    ) {
        $this->hasSubMenu($menu)->shouldBe(false);

        $menus = new ArrayCollection([$menu]);
        $this->setSubMenus($menus);
        $this->getSubMenus()->shouldReturn($menus);
    }

    public function its_addSubMenu_should_add_submenu_item(
        MenuInterface $menu
    ) {
        $this->hasSubMenu($menu)->shouldBe(false);
        $this->addSubMenu($menu);
        $this->hasSubMenu($menu)->shouldBe(true);
    }

    public function its_meta_should_be_mutable()
    {
        $this->hasMeta('foo')->shouldBe(false);

        $this->addMeta('foo', 'bar');
        $this->getMeta('foo')->shouldReturn('bar');
        $this->getMeta()->shouldHaveKey('foo');

        $this->setMeta($meta = ['hello' => 'world']);
        $this->hasMeta('foo')->shouldBe(false);
        $this->hasMeta('hello')->shouldBe(true);
        $this->getMeta()->shouldReturn($meta);
    }

    public function its_name_should_be_mutable()
    {
        $this->getName()->shouldReturn('name');
        $this->setName('foo');
        $this->getName()->shouldReturn('foo');
    }

    public function its_label_should_be_mutable()
    {
        $this->setLabel('foo');
        $this->getLabel()->shouldReturn('foo');
    }

    public function its_icon_should_be_mutable()
    {
        $this->setIcon('foo');
        $this->getIcon()->shouldReturn('foo');
    }

    public function its_url_should_be_mutable()
    {
        $this->setUrl('url');
        $this->getUrl()->shouldReturn('url');
    }
}
