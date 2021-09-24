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

namespace Doyo\Menu\Bridge\Symfony\Controller;

use Doyo\Menu\Contracts\MenuGeneratorInteface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class MenuController
{
    public function __invoke(MenuGeneratorInteface $menuFactory, SerializerInterface $serializer): Response
    {
        $menus = $menuFactory->getMenus();
        $json  = $serializer->serialize($menus, 'json');

        return new Response($json, 200, [
            'Content-Type' => 'application/json',
        ]);
    }
}
