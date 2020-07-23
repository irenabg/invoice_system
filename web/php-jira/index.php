<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require   "phpmailer_v2.0.4/src/Exception.php";
require   "phpmailer_v2.0.4/src/PHPMailer.php";
require   "phpmailer_v2.0.4/src/SMTP.php";

use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\Transition;
use JiraRestApi\JiraException;

$projectname="YEPTEXT";

function CustomMail($to, $subject, $body, $is_html=true, $bcc = false,$reply_to_mail=false,$reply_to_name=false)
{

    $mail = new PHPMailer;

    $mail->IsSMTP();


    $mail->Username = "build@protexting.com";
    $mail->Password = "MH{Dh39m";
    $mail->From = "build@protexting.com";
    $mail->Host ='mbox.protexting.com';
    $mail->Port = 587;

    if($reply_to_mail){
        $mail->ClearReplyTos();
        $mail->addReplyTo($reply_to_mail, $reply_to_name);

    }

    //for local test
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls'; // ssl is depracated


    $mail->Mailer = 'smtp';
/// $mail->SMTPDebug = 5;
    $mail->CharSet = 'UTF-8';





    ///  $body = preg_replace("[\]", '', $body);
    $mail->MsgHTML($body);
    $mail->AltBody = '';
    $mail->IsHTML(true);

    $mail->FromName ="Build Jenkins";
    $mail->Subject = $subject;

    if ($bcc) {

        $mail->AddBCC($bcc);

    }

    $aParts = explode(",", $to);
    if (is_array($aParts) && count($aParts) > 0)
    {
        foreach ($aParts as $sMailTo)
        {
            $sMailTo = trim($sMailTo);
            $mail->AddAddress($sMailTo);
        }
    }
    else
        $mail->AddAddress($to);

    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;

    }

}


function searcharray($value, $key, $array) {
    foreach ($array as $k => $val) {
        if ($val[$key] == $value) {
            return $k;
        }
    }
    return null;
}

function ChangeStatus($issueKey,$projectname){

    $issueKey = $projectname."-".$issueKey;

    try {
        $transition = new Transition();
        $transition->setTransitionName('BUILD ON PROD');
        $transition->setCommentBody('performing the transition via Jenkins.');

        $issueService = new IssueService();

        $issueService->transition($issueKey, $transition);
    } catch (JiraRestApi\JiraException $e) {
        $this->assertTrue(FALSE, "add Comment Failed : " . $e->getMessage());
    }

}
function string_between_two_string($str, $starting_word, $ending_word)
{
    $subtring_start = strpos($str, $starting_word);
    //Adding the strating index of the strating word to
    //its length would give its ending index
    $subtring_start += strlen($starting_word);
    //Length of our required sub string
    $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
    // Return the substring from the index substring_start of length size
    return substr($str, $subtring_start, $size);
}


exec('git rev-parse --verify HEAD 2> /dev/null', $output);
$hash = $output[0];

exec("git show -s $hash", $output);
$send=false;
$body="";
foreach($output as $value){

    if(strpos($value,$projectname."-") !== false){

        $body.="</br>";
        preg_match('~'.$projectname.'-(\d+)~', $value, $m );
        var_dump($m); // $m[1] is your string
        ChangeStatus($m[1],$projectname);
        $body.=$value;
        $send=true;
        $body.="</br>";

    }
}
### send email
if($send)
    CustomMail("build@protexting.com", $projectname." Build # ".$_SERVER['argv'][1]." JIRA Tickets", $body);

/*require 'vendor/autoload.php';

use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\JiraException;

$issueKey = "YEPTEXT-341";

try {
    $issueField = new IssueField(true);

    $issueField->setIssueType("Task")
                ->setDescription("This is a shorthand for a set operation on the summary field")
    ;

    // optionally set some query params
    $editParams = [
        'notifyUsers' => false,
    ];

    $issueService = new IssueService();

    // You can set the $paramArray param to disable notifications in example
    $ret = $issueService->update($issueKey, $issueField, $editParams);

    var_dump($ret);
} catch (JiraRestApi\JiraException $e) {
    $this->assertTrue(FALSE, "update Failed : " . $e->getMessage());
}
*/


/*

use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\Comment;
use JiraRestApi\JiraException;

$issueKey = "YEPTEXT-341";

try {
    $comment = new Comment();

    $body = <<<COMMENT
Adds a new comment to an issue.
* Bullet 1
* Bullet 2
** sub Bullet 1
** sub Bullet 2
* Bullet 3
COMMENT;

    $comment->setBody($body);


    $issueService = new IssueService();
    $ret = $issueService->addComment($issueKey, $comment);
    print_r($ret);
} catch (JiraRestApi\JiraException $e) {
    $this->assertTrue(FALSE, "add Comment Failed : " . $e->getMessage());
} */