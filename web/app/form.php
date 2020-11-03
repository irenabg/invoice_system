<?php

require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;
use Mpdf\MpdfException;
$mpdf = new Mpdf(['tempDir' => __DIR__."/tmp/"]);


        $client       = $_POST['client'] ?? "";
        $currency     = $_POST['currency'] ?? "";
        $invoice_no   = $_POST['invoice_no'] ?? "";
        $issuing_date = $_POST['issuing_date'] ?? "";
        $issuer       = $_POST['issuer'] ?? "";
        $vat          = $_POST['vat'] ?? "";
        $option_value = $_POST['option_value'] ?? "";
        $pdf          = $_POST['pdf'] ?? "";
        $mail         = $_POST['mail'] ?? "";
        $email_to     = $_POST['email_to'] ?? "";
        $email_from   = $_POST['email_from'] ?? "";
        $subject      = $_POST['subject'] ?? "";
        $body         = $_POST['body'] ?? "";
        $filepath     = "images/" . $_FILES["uploadedFile"]["name"];
        copy($_FILES["uploadedFile"]["tmp_name"],  $filepath);


        $date = date('Y/m/d');
        ob_start();  // start output buffering
        $content = ob_get_clean(); // get content of the buffer and clean the buffer
            $cur = "";

            if ($currency === "Euro"){
                $cur = '€';
            }elseif ($currency === 'US'){
                $cur = '$';
            }
            $td="";
            $amount = 0;
            foreach($option_value as $item) {


                $amount += $item['cost']*$item['quantity'];
                $td.="<tr class='item'>
        <td>".$item['item']."
        </td>

        <td>
            ".$cur." ".$item['cost']."
        </td>

        <td>
            ".$item['quantity']."
        </td>

        <td>
            ".$cur." ".$item['cost']*$item['quantity']."
        </td>
    </tr>";
            }

            $html = "<html lang='en'>
    <head>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"../style/invoice.css\">

        <meta charset=\"utf-8\">
        <title>$issuer Invoice</title>

    </head>

    <body>

     <div class=\"invoice-box\">
        <table>
            <tr class=\"top\">
                <td colspan=\"2\">
                    <table>
                        <tr>
                            <td>
                                <h1> <b> </b> </h1>
                            </td>
                            <td class=\"title\">
                                <img src=".$filepath." height=150 width=250 />
                            </td>
                            <td>
                                Invoice #: $invoice_no </br>
                                Issuing date: $issuing_date<br>
                                Date:  $date
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class=\"information\">
                <td colspan=\"2\">
                    <table>
                        <tr>
                            <td>
                                Issuer: $issuer
                            </td>

                            <td>
                                Client: $client
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class=\"heading\">
                <td>
                    Item
                </td>

                <td>
                    Cost
                </td>
                
                <td>
                    Quantity
                </td>
                
                <td>
                    Total
                </td>
            </tr>
            

             ".$td."      
                
                   
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    TAX: $vat %
                </td>
            </tr>
            <tr class=\"total\">
                <td></td>
                <td></td>
                <td></td>
                <td>
                    Total: $cur $amount
                </td>
            </tr>
        </table>
    </div>
    </body>
</html>";


            if($pdf){
                /*$download_pdf = new DownloadPdf();
                $download_pdf->downloadPdf($html);*/
                $mpdf = new Mpdf();
                $mpdf->debug = true;

                $mpdf->WriteHTML($html);

                $mpdf->Output('invoice.pdf', 'D');

            }elseif ($mail){

                /*$send_mail = new SendMail();
                $send_mail->sendMail($email_to, $email_from, $subject, $body, $html, $issuer, $client);*/
                $mpdf = new Mpdf();
                $mpdf->debug = true;
                try
                {
                    $mpdf->WriteHTML($html);
                    $content = $mpdf->Output('invoice.pdf', 'S');

                    $attachment = new Swift_Attachment($content, 'invoice.pdf', 'application/pdf');

                    $message = (new Swift_Message($subject))
                        ->setFrom(array($email_from => $issuer))
                        ->setTo(array($email_to => $client))
                        ->setBody($body)
                        ->attach($attachment);
                    $mailer = new Swift_Mailer(new Swift_SendmailTransport());

                    $mailer->send($message);
                    $mpdf->Output('invoice.pdf','D');
                }catch (MpdfException $e)
                {
                    echo $e->getMessage();

                }
            }

?>