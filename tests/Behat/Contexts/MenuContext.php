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

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Doyo\Menu\Factory\YamlMenuFactory;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MenuContext implements Context
{
    private array $menus;
    private JsonMenuContext $jsonMenuContext;

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope): void
    {
        $this->jsonMenuContext = $scope->getEnvironment()->getContext(JsonMenuContext::class);
    }

    /**
     * @Given I have yaml menu configuration:
     */
    public function iHaveYamlMenuConfiguration(PyStringNode $string)
    {
        $factory     = new YamlMenuFactory();
        $this->menus = $factory->fromYaml((string) $string);
    }

    /**
     * @When I serialize menu to json
     */
    public function iSerializeMenuToJson(): void
    {
        $encoders    = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer  = new Serializer($normalizers, $encoders);
        $json        = $serializer->serialize($this->menus, 'json');
        $this->jsonMenuContext->setJson($json);
    }
}
