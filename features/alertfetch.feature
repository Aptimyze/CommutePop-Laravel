Feature: Alert Fetch

  In order to send CommutePop alerts
  As an administrator
  I need to be able to fetch alerts that are due to be sent

  Scenario: Alert is successfully fetched
  	Given an alert is due now
  	Then the alert handler should fetch at least one alert
