Feature: Membership

  In order to give registered members the ability to create and manage alerts
  As an administrator
  I need authentication and registration for users

  Scenario: Registration
    When I register "JonDoe" "john@example.com"
    Then I should have an account




    # Given I am on "/alerts"
    # When I fill in "email" with "jeff@bezos.com"
    # And I fill in "password" with "secretsauce"
    # And I press "login-button"
    # Then I should see "Active Alerts"