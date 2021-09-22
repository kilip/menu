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

namespace Doyo\Menu\Tests\Behat\Contexts;

use Behatch\Context\JsonContext;
use Behatch\Json\Json;
use Behatch\Json\JsonInspector;

class JsonMenuContext extends JsonContext
{
    protected string $json;

    public function __construct()
    {
        $this->inspector = new JsonInspector('javascript');
    }

    public function setJson(string $json): void
    {
        $this->json = $json;
    }

    protected function getJson()
    {
        return new Json($this->json);
    }
}
