## CommutePop
### A Cloud Service for Public Transit Commuters

CommutePop is a web application built for public transit commuters. Nearly all public transit apps and services seem geared towards users who don't know where they're going or how to get there. CommutePop is for those who just want to know *when*. Sign up for alerts, and get them sent directly to your inbox just before you need to leave, so you know what time to leave your desk.

### Beta Program

If you live in Portland, Oregon, and commute to work on TriMet (bus/max/streetcar), CommutePop is looking for beta testers! Go to [CommutePop.com](http://commutepop.com) to sign up.

### Development

CommutePop is under active development. Greg Kaleka is the founder and lead developer. Front-end help from Dan Oswalt.

### How it Works

##### Creating an alert
1. A user submits a secure form (secured with robust validation and a CSRF token to prevent cross-site request forgery) with information about their commute, and where they want their alert sent
2. Their information is submitted to a MySQL database, including calculated fields used to deterimine when, precicely, the alert needs to be sent

##### Sending alerts
1. A cron job on the server checks each minute to determine if any alerts are due. If there are, they are stored in an Alert object.
2. Each Alert object is looped through and its properties are used to determine the parameters for a call made to the TriMet API
3. The API response (in JSON) is parsed, and an array of upcoming vehicle arrivals is passed to an email view
4. The email view is sent to the recipient, and the database is updated with a new "last sent" value to prevent another alert from being sent until it is due again the following day

### Tools and Software Used

* Digitalocean Droplet
* Ubuntu
* NGiИX
* PHP
* MySQL
* Laravel 5.1
* VirtualBox
* Vagrant
* Composer
* Git
* Slack
* Sublime Text
* PHPStorm