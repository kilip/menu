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

namespace Doyo\Menu\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class MenuExtension extends Extension
{
    /**
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        /** @var array<array-key,scalar|null> $config */
        $config        = $this->processConfiguration($configuration, $configs);

        $this->setParameters($container, $config);

        $locator = new FileLocator(__DIR__.'/../Resources/services');
        $loaders = new XmlFileLoader($container, $locator);
        $loaders->load('menu.xml');
    }

    /**
     * @param array<array-key,scalar|null> $config
     */
    private function setParameters(ContainerBuilder $container, array $config): void
    {
        $menuConfigDir = $config['menu_config_dir'] ?? null;
        if (null !== $menuConfigDir) {
            $container->setParameter('doyo.menu.menu_config_dir', $menuConfigDir);
        }
    }
}
