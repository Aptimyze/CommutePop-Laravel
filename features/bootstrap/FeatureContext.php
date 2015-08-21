<?php
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use PHPUnit_Framework_Assert as PHPUnit;
use Laracasts\Behat\Context\Migrator;
use Laracasts\Behat\Context\DatabaseTransactions;
use Carbon\Carbon;
use App\Alert;
use App\AlertHandler;
use App\Curl;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    use Migrator, DatabaseTransactions;

    private $name;
    private $email;

    /**
     * An alert handler instance
     * @var AlertHandler
     */
    private $handler;

    /**
     * @When I register :name :email
     */
    public function iRegister($name, $email)
    {
        $this->name = $name;
        $this->email = $email;

        $this->visit('auth/register');

        $this->fillField('name', $name);
        $this->fillField('email', $email);
        $this->fillField('password', 'password');
        $this->fillField('password_confirmation', 'password');

        $this->pressButton('register');
        $this->printLastRequest();
    }

    /**
     * @Then I should have an account
     */
    public function iShouldHaveAnAccount()
    {
        $this->assertSignedIn();
    }

    /**
     * @Given I have an account :name :email
     */
    public function iHaveAnAccount($name, $email)
    {
        $this->iRegister($name, $email);
        $this->visit('auth/logout');
    }

    /**
     * @When I sign in
     */
    public function iSignIn()
    {
        $this->visit('auth/login');

        $this->fillField('email', $this->email);
        $this->fillField('password', 'password');
        $this->pressButton('login-button');
    }

    /**
     * @When I sign in with invalid credentials
     */
    public function iSignInWithInvalidCredentials()
    {
        $this->email = 'invalid@example.com';
        $this->iSignIn();
    }

    /**
     * @Then I should be logged in
     */
    public function iShouldBeLoggedIn()
    {
        $this->assertSignedIn();
    }

    /**
     * @Then I should not be signed in
     */
    public function iShouldNotBeSignedIn()
    {
        PHPUnit::assertTrue(Auth::guest());

        $this->assertPageAddress('auth/login');
        $this->assertPageContainsText('These credentials do not match our records.');
    }

    private function assertSignedIn()
    {
        PHPUnit::assertTrue(Auth::check());
        $this->assertPageAddress('/alerts');
    }

    /**
     * @Given an alert is due now
     */
    public function anAlertIsDueNow()
    {
        $timezone = 'America/Los_Angeles';
        $now = Carbon::now($timezone);
        $soon = $now->addMinutes(1);
        $yesterday = Carbon::yesterday();
        $user = factory('App\User')->create();

        $alert = new Alert();
        $alert->user_id = $user->id;
        $alert->email = 'greg.kaleka@gmail.com';
        $alert->stop = 5020;
        $alert->route = 15;
        $alert->departure_time = $soon;
        $alert->time_to_stop = 0;
        $alert->lead_time = 0;
        $alert->alert_time = $soon;
        $alert->last_sent = $yesterday;
        $alert->timezone = $timezone;
        $alert->sunday = 1;
        $alert->monday = 1;
        $alert->tuesday = 1;
        $alert->wednesday = 1;
        $alert->thursday = 1;
        $alert->friday = 0;
        $alert->saturday = 0;
        $alert->sunday = 0;

        $alert->save();
    }

    /**
     * @Then the alert handler should fetch at least one alert
     */
    public function theAlertHandlerShouldFetchAtLeastOneAlert()
    {
        $handler = new AlertHandler(new Curl);
        $alertsDue = $handler->fetch($this->fetchRange);
        PHPUnit::assertFalse($alertsDue->isEmpty());
        return $alertsDue;
    }

    /**
     * @Then the alert handler should fetch a response from TriMet
     */
    public function theAlertHandlerShouldFetchAResponseFromTrimet()
    {
        $handler = new AlertHandler(new Curl);
        $alert = $this->theAlertHandlerShouldFetchAtLeastOneAlert()[0];
        $arrivalData = $handler->getTrimetArrivalData($alert);
        PHPUnit::assertNotEmpty($arrivalData);
    }

    /**
     * @Then the alert handler should send an email
     */
    public function theAlertHandlerShouldSendAnEmail()
    {
        $handler = new AlertHandler(new Curl);
        $stats = $handler->sendAlertEmails(env('ALERT_FETCH_RANGE'));
        print($stats);
        PHPUnit::assertGreaterThan(0, $stats);
    }

    /**
     * @When I visit alert send endpoint
     */
    public function iVisitAlertSendEndpoint()
    {
        $this->visit(env('ALERT_SEND_ENDPOINT'));
    }

    /**
     * @Then the scheduler should send an email
     */
    public function theSchedulerShouldSendAnEmail()
    {
        Artisan::call('inspire');
    }

    /**
     * @Given a time machine takes us to when an alert is due
     */
    public function aTimeMachineTakesUsToWhenAnAlertIsDue()
    {
        throw new PendingException();
    }
}
