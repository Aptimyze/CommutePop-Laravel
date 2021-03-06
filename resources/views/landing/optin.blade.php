<?php
use App\Curl;

    $mailchimpKey = env('MAILCHIMP_KEY');
    $listURL = env('CP_LIST_URL');
    header("Cache-Control: no-transform,public,max-age=300");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CommutePop | Making TriMet Commuting Easier</title>

        <link href='http://fonts.googleapis.com/css?family=Lato:100,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{!! asset('css/landing.css') !!}">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}

    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">CommutePop</div>
                <div class="subtitle">Comming Soon to PDX</div>
                <h1 class="summary">Live transit times.<br>Right in your inbox.<br>Exactly when you need them.</h1>
                <?php
                    function validate() {
                        $trimmed_email_address = trim($_POST["email"]);
                        $email_address = filter_var($trimmed_email_address, FILTER_SANITIZE_EMAIL);
                        return filter_var($email_address, FILTER_VALIDATE_EMAIL);
                    }

                    if($_SERVER["REQUEST_METHOD"] == "POST" && validate() == TRUE ):
                        //mailchimp
                        $postFields = '{"email_address":"' . $_POST['email'] . '","status":"pending"}';
                        $header = 'Authorization: apikey ' . $mailchimpKey;
                        $response = Curl::postJSON($listURL, $postFields, $header);
                    ?>
                    <div class="share">
                        <p>Thanks! We'll be in touch.</p><p>Have friends who might be interested?</p>
                        <ul class="social-nav model-2">
                          <li><a href="https://twitter.com/share" class="twitter" data-url="http://leaveat.com" data-text="Coming soon: #TriMet email alerts for commuters." data-via="gregkaleka">t<i class="fa fa-twitter"></i></a></li>
                          <li><a href="#" class="facebook">f<i class="fa fa-facebook"></i></a></li>
                          <li><a href="#" class="google-plus">g+<i class="fa fa-google-plus"></i></a></li>
                          <li><a href="#" class="linkedin">li<i class="fa fa-linkedin"></i></a></li>
                        </ul>
                        <br/>
                    </div>
                    <?php else: ?>
                        <h3 class="beta">Interested in becoming a beta tester?</h3>
                        <h3 id='message' display='none' ></h3>
                        {!! Form::open(array('url' => '/')) !!}
                        <div>
                            {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control email']) !!}
                        </div>
                            {!! $errors->first('email', '<small class="error">:message</small>'); !!}
                            {!! Form::submit('I\'m Interested', ['class' => 'btn']) !!}
                        </div>

                    </form>
                <?php endif; ?>
            </div>
        </div>
        <script type="text/javascript" src="{!! asset('js/jquery.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/validate.js') !!}"></script>
    </body>
</html>
