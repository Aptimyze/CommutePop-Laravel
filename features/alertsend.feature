Feature: Alert Send

  In order to know when to leave
  As a user
  I need to recieve alerts when I have scheduled them

  @mail
  Scenario: Alert is successfully sent
  	Given an alert is due now
  	Then the alert handler should fetch an alert
    And the alert handler should send an email


  # Scenario: Alert is successfully sent for existing database user
  #   Given a time machine takes us to when an alert is due
  #   When I visit alert send endpoint
  #   Then the alert handler should send an email


  # Scenario: Alert is successfully sent from the scheduler
  # 	Given an alert is due now
  # 	When I visit alert send endpoint
  # 	Then the scheduler should send an email