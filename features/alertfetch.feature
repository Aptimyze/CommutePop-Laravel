Feature: Alert Send

  In order to know when to leave
  As a user
  I need to recieve alerts when I have scheduled them

  Scenario: Alert is successfully sent
  	Given an alert is due now
  	Then the alert handler should send an email

  Scenario: Alert is successfully sent from route ping
  	Given an alert is due now
  	When I visit alert send endpoint
  	Then the alert handler should send an email