Feature: Log In with Email
  In order to log in
  As a user
  I want to enter my email and password and see my alerts dashboard.

  Scenario: Log in as Test User
    Given I am on "/alerts"
    # When I follow "Click Me"
    # Then the url should match "/example"
    When I fill in "email" with "test@email.com"
    And I fill in "password" with "secret"
    And I press "login-button"
    Then I should see "PDOException"