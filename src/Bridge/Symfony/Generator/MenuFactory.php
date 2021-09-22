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
use Doyo\Menu\Contracts\MenuItemInterface;
use Doyo\Menu\Generator\ArrayMenuFactory;
use Doyo\Menu\MenuItem;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Yaml\Yaml;

class MenuFactory extends ArrayMenuFactory
{
    private string $configDir;
    private AuthorizationCheckerInterface $authChecker;

    public function __construct(
        string $configDir,
        AuthorizationCheckerInterface $authChecker
    ) {
        parent::__construct(MenuItem::class);

        if ( ! is_dir($configDir)) {
            throw MenuException::configDirNotExists($configDir);
        }
        $this->configDir   = $configDir;
        $this->authChecker = $authChecker;
    }

    public function getMenus(): array
    {
        if (empty($this->menus)) {
            $this->parseYamls();
        }

        return $this->menus;
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
     * @param array<array-key,string> $item
     * @psalm-suppress MixedMethodCall
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function parseMenuItem(array $item): ?MenuItemInterface
    {
        $menu    = parent::parseMenuItem($item);
        $granted = true;

        if (null !== $menu) {
            if ($menu->hasMeta('security')) {
                $expression = $menu->getMeta('security');
                \assert(\is_string($expression));
                $expression = new Expression($expression);
                $granted    = $this->authChecker->isGranted($expression);
            }
        }

        return $granted ? $menu : null;
    }
}
