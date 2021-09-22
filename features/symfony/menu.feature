@symfony
Feature: Symfony Integration
  Scenario: Successfully access menu
    Given I add "Accept" header equal to "application/json"
    When I send a "GET" request to "/menu"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON node "root[0].name" should be equal to "menu1"
    And the JSON node "root[0].url" should be equal to "/menu1"
    And the JSON node "root[0].label" should be equal to "menu1"
    And the JSON node "root[0].children[1]" should not exist

  Scenario: menu for logged in user
    Given I am logged in as user
    When I send a "GET" request to "/menu"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON node "root[0].children[1]" should exist
    And the JSON node "root[0].children[2]" should not exist

  Scenario: menu for logged in admin
    Given I am logged in as admin
    When I send a "GET" request to "/menu"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON node "root[0].children[1]" should exist
    And the JSON node "root[0].children[2]" should exist
