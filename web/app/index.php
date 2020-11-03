    <!DOCTYPE html>
    <html>
    <head>
        <title>Contact form</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="/js/my.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
       </head>
    <body>
    <div class="container">

      <form id="contact_form" name="contact_form" class="well form-horizontal"  method="post" action="form.php" enctype="multipart/form-data">
            <fieldset>
                <h1 style="text-align: center"><b>INVOICE CREATOR</b></h1>
                </br></br></br>

              <div class="form-group">
                <label class="col-md-4 control-label">Logo</label>
                <div class="col-md-4 selectContainer">
                  <div class="input-group">
                    <span>Upload a Logo:</span>
                      <input type="file" name="uploadedFile" />
                  </div>
                </div>
              </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Client</label>
                    <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="client" placeholder="Client" class="form-control"  type="text">
                        </div>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label class="col-md-4 control-label">Matter</label>
                    <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select name="matter" class="form-control selectpicker">
                                <option value="">Select matter</option>
                                <option>Matter Recommended Amount (Expenses) (LVL)</option>
                                <option>Matter Venue County	</option>
                                <option >Matter Approved To Date Amount (Expenses) (LVL)</option>
                                <option >Matter Approved To Date Amount (Fees) (LVL)</option>
                                <option >Matter Approved to Date Amount (LVL)</option>
                                <option >Life Of Matter Spend</option>
                                <option >Matter Contact	</option>
                                <option >Matter Days Open</option>
                                <option >Matter Currency</option>
                            </select>
                        </div>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-md-4 control-label">Issuer</label>
                    <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="issuer" placeholder="Issuer" class="form-control"  type="text">
                        </div>
                    </div>
                </div>
                <!--TODO: add language picker-->
                <!--<div class="form-group">
                    <label class="col-md-4 control-label">Language</label>
                    <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select name="language" class="form-control selectpicker">
                                <option value="">Select language</option>
                                <option>Bulgarian</option>
                                <option>English</option>
                            </select>
                        </div>
                    </div>
                </div>-->

                <div class="form-group">
                    <label class="col-md-4 control-label">Currency</label>
                    <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                            <select name="currency" class="form-control selectpicker">
                                <option value="">Select currency</option>
                                <option>US</option>
                                <option>Euro</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" >Invoice No:</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                            <input name="invoice_no" placeholder="Invoice No" class="form-control"  type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Issuing date:</label>
                    <div class="col-md-4 inputGroupContainer input-group date" id='datetimepicker1'>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            <input name="issuing_date" type='text' class="form-control" id='datepicker' >
                        </div>
                    </div>
                </div>
              <!--  <div class="form-group">
                    <label class="col-md-4 control-label">Amount:</label>
                    <div class="col-md-4 inputGroupContainer input-group date">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                            <input name="amount" placeholder="Amount" class="form-control width"  type="text"> €0.00
                        </div>
                    </div>
                </div>-->
                <!-- Text input-->
    <!--
                <div class="form-group">
                    <label class="col-md-4 control-label">Discount:</label>
                    <div class="col-md-4 inputGroupContainer input-group date">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                            <input name="discount" placeholder="Discount" class="form-control width"  type="text"> %€0.00
                            </label>
                        </div>
                    </div>
                </div>-->

                <div class="form-group">
                    <label class="col-md-4 control-label">TAX:</label>
                    <div class="col-md-4 inputGroupContainer input-group date">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                                <input name="vat" value="20" class="form-control width"  type="text"> %€0.00
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Add Row -->
                <div id="object">
                    <div class="row">
                        <div class="col-md-8 column">
                            <table class="table table-bordered table-hover" id="tab_logic">
                                <thead>
                                <tr id="row">
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        Item
                                    </th>
                                    <th class="text-center">
                                        Cost
                                    </th><th class="text-center">
                                        Quantity
                                    </th>
                                    <th class="text-center">
                                        Total
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id='addr0'>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        <input id="item" type="text" name='option_value[0][item]'  placeholder='Item' class="form-control"/>
                                    </td>
                                    <td>
                                        <input id="cost" type="text" name='option_value[0][cost]' placeholder='Cost' class="form-control"/>
                                    </td>
                                    <td>
                                        <input id="qty" type="text" name='option_value[0][quantity]' placeholder='Quantity' class="form-control"/>
                                    </td>
                                    <td>
                                        <input id="total" type="text" name='option_value[0][total]' placeholder='Total' class="form-control"/>
                                    </td>
                                </tr>
                                <tr id='addr1'></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" id="object">
                    <a id="add_row" class="btn btn-default pull-left">Add Row</a><a id='delete_row' class=" btn btn-default">Delete Row</a>
                </div>


              <button type="button" class="btn btn-info" id="formButton">Send by email</button>

              <div id="hidden">
                <div class="row">
                  <div class="col-md-8 column">
                    <div class="form-group">
                      <label class="col-md-4 control-label">To:</label>
                      <div class="col-md-4 inputGroupContainer input-group date">
                        <div class="input-group">
                          <input name="email_to" placeholder="Email to" class="form-control "  type="text">
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">From:</label>
                      <div class="col-md-4 inputGroupContainer input-group date">
                        <div class="input-group">
                          <input name="email_from" placeholder="Email from" class="form-control"  type="text">
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Subject:</label>
                      <div class="col-md-4 inputGroupContainer input-group date">
                        <div class="input-group">
                          <input name="subject" placeholder="Subject" class="form-control"  type="text">
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Email body:</label>
                      <div class="col-md-4 inputGroupContainer input-group date">
                        <div class="input-group">
                          <textarea name="body"  class="form-control"> </textarea>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3"><br>
                  <input type="submit" class="btn btn-info" name="mail" value="SEND AND DOWNLOAD">
                </div>
              </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4"><br>
                      <input type="submit"  class="btn btn-success" name="pdf" value="DOWNLOAD">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    </div><!-- /.container -->
    </body>
    </html>