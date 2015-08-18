Feature: Alert Send

  In order to know when to leave
  As a user
  I need to recieve alerts when I have scheduled them

  Scenario: Alert is successfully fetched
  	Given an alert is due now
  	Then the alert handler should send an email