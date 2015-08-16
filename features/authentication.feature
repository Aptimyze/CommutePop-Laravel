Feature: Membership

  In order to give registered members the ability to create and manage alerts
  As an administrator
  I need authentication and registration for users

  Scenario: Registration
    When I register "JonDoe" "john@example.com"
    Then I should have an account

  Scenario: Successful Authentication
    Given I have an account "JohnDoe" "john@example.com"
    When I sign in
    Then I should be logged in

  Scenario: Failed Authentication
    When I sign in with invalid credentials
    Then I should not be signed in