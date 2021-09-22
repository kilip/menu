Feature: YAML Menu Config
  Background:
    Given I have yaml menu configuration:
    """
    - name: test1
      icon: test1
      label: Test Label
      url: /test1
      meta:
        foo: bar
        hello: world
      children:
        - name: child1
          icon: child1
          url: /child1
          meta:
            foo: bar
            hello: world
          children:
            - name: child11
              icon: child11
              url: /child11
              meta:
                foo: bar
                hello: world
    - name: test2
      url: /test2
      icon: test2
      label: Test2 Label
    """

  Scenario: Checking root menu
    When I serialize menu to json
    Then the JSON node "root[0].name" should be equal to "test1"
    And the JSON node "root[0].icon" should be equal to "test1"
    And the JSON node "root[0].label" should be equal to "Test Label"
    And the JSON node "root[0].url" should be equal to "/test1"
    And the JSON node "root[0].meta.foo" should be equal to "bar"
    And the JSON node "root[0].meta.hello" should be equal to "world"
    And the JSON node "root[1].name" should be equal to "test2"
    And the JSON node "root[1].icon" should be equal to "test2"
    And the JSON node "root[1].url" should be equal to "/test2"

  Scenario: Checking child menu level 1
    When I serialize menu to json
    Then the JSON node "root[0].children[0].name" should be equal to "child1"
    And the JSON node "root[0].children[0].icon" should be equal to "child1"
    And the JSON node "root[0].children[0].label" should be equal to "child1"
    And the JSON node "root[0].children[0].url" should be equal to "/child1"
    And the JSON node "root[0].children[0].meta.foo" should be equal to "bar"
    And the JSON node "root[0].children[0].meta.hello" should be equal to "world"

  Scenario: Checking child menu level 2
    When I serialize menu to json
    Then the JSON node "root[0].children[0].children[0].name" should be equal to "child11"
    And the JSON node "root[0].children[0].children[0].label" should be equal to "child11"
    And the JSON node "root[0].children[0].children[0].icon" should be equal to "child11"
    And the JSON node "root[0].children[0].children[0].url" should be equal to "/child11"
    And the JSON node "root[0].children[0].children[0].meta.foo" should be equal to "bar"
    And the JSON node "root[0].children[0].children[0].meta.hello" should be equal to "world"

