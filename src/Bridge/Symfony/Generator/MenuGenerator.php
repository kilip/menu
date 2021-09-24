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

namespace Doyo\Menu\Bridge\Symfony\Generator;

use Doyo\Menu\Bridge\Symfony\Exception\MenuException;
use Doyo\Menu\Contracts\MenuInterface;
use Doyo\Menu\Generator\ArrayMenuGenerator;
use Doyo\Menu\Menu;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Yaml\Yaml;

class MenuGenerator extends ArrayMenuGenerator
{
    private string $configDir;
    private AuthorizationCheckerInterface $authChecker;
    private AdapterInterface $cacheAdapter;

    /**
     * @param class-string $menuClass
     *
     * @throws MenuException
     */
    public function __construct(
        AuthorizationCheckerInterface $authChecker,
        AdapterInterface $adapter,
        string $configDir,
        string $menuClass = Menu::class
    ) {
        parent::__construct($menuClass);

        if ( ! is_dir($configDir)) {
            throw MenuException::configDirNotExists($configDir);
        }
        $this->configDir    = $configDir;
        $this->authChecker  = $authChecker;
        $this->cacheAdapter = $adapter;
    }

    public function getMenus(): array
    {
        if (empty($this->menus)) {
            $this->parseYamls();
        }

        return $this->secureMenus();
    }

    /**
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    private function parseYamls(): void
    {
        $finder = Finder::create()
            ->in($this->configDir)
            ->name('*.yaml')
            ->name('*.yml')
            ->sortByName();

        $definitions = [];

        /** @var SplFileInfo $file */
        foreach ($finder->files() as $file) {
            /** @var array<array-key, array<array-key, string>> $yaml */
            $yaml        = Yaml::parseFile((string) $file->getRealPath());
            $definitions = array_merge($definitions, $yaml);
        }

        $this->generateMenus($definitions);
    }

    /**
     * @return MenuInterface[]
     */
    private function secureMenus(): array
    {
        $menus = [];
        foreach ($this->menus as $menu) {
            if ($this->isGranted($menu)) {
                $this->secureSubMenus($menu);
                $menus[] = $menu;
            }
        }

        return $menus;
    }

    /**
     * @psalm-suppress MixedAssignment
     */
    private function secureSubMenus(MenuInterface $menu): void
    {
        foreach ($menu->getSubMenus() as $subMenu) {
            /** @var MenuInterface $subMenu */
            if (false === $this->isGranted($subMenu)) {
                $menu->removeSubMenu($subMenu);
            }
            $this->secureSubMenus($subMenu);
        }
    }

    private function isGranted(MenuInterface $menu): bool
    {
        if ($menu->hasMeta('security')) {
            $expression = $menu->getMeta('security');
            \assert(\is_string($expression));
            $expression = new Expression($expression);

            return $this->authChecker->isGranted($expression);
        }

        return true;
    }
}
