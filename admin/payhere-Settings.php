<?php
require_once ( dirname(__FILE__) . '/payhere-connect.php' );

functionPayhereSetup(); //Calling payhere settings

function functionPayhereSetup() {//display the edit table informations
    global $payhereObject;
    $payhereObject = payhereConnect::payhereOptions(); //retrieve data information
    //Display array result uncomment below code
//    $payhere_Row_Result = json_decode(json_encode($payhereObject), True); //convert object to array variable
//    print_r($payhere_Row_Result);

    foreach ($payhereObject as $payhereInformation) {
        $option_value = unserialize($payhereInformation->option_value);
        $paymentOpts = $option_value['payOpts'];
        $payherMainDetails = $option_value;
    }

    if ($option_value['payhere_mode'] == '1') {
        $chkBoxValue1 = "checked";
    }
    if ($payherMainDetails['payhere_isactive'] == '1') {
        $chkBoxValue2 = "checked";
    }
    $msg = $_GET['status'];
    if ($payherMainDetails['methodname'] == 'PayHere Transfer') {
        ?>

        <div id="payhereinfomation"><h2>Payhere Setting</h2><hr/> 
            <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
                <table><tr><td align="top">Payment method</td>
                        <td><input type="text" name="payment_method" id="payment_method" readonly size="50" value="<?php echo $option_value['methodname']; ?>"/>
                            <p class="description">It will act as a name (label) of your payment method on your site</p></td></tr>
                    <tr><td><?php echo $paymentOpts[0]['title']; ?></td>
                        <td><input type="text" name="<?php echo $paymentOpts[0]['fieldname'] ?>" id="<?php echo $paymentOpts[0]['fieldname'] ?>" value="<?php echo $paymentOpts[0]['value'] ?>"/>
                            <p class="description"><?php echo $paymentOpts[0]['description'] ?></p></td></tr>
                    <tr><td>Payment Gateway Active</td>
                        <td><input type="checkbox" name="payhere_isactive" id="payhere_isactive" value="1" <?php echo $chkBoxValue2; ?>>
                            <p class="description">Check this if you want to activate payhere Payment gateway</p></td></tr>
                    <tr><td>Use in test mode?</td>
                        <td><input type="checkbox" name="payhere_mode" id="payhere_mode" value="1" <?php echo $chkBoxValue1; ?>>
                            <p class="description">Check this if you want to use payhere in test mode</p></td></tr>
                    <tr><td>Payhere Secret</td>
                        <td><input type="text" name="payhere_secret" id="payhere_secret" size="50" value="<?php echo $option_value['payhere_secret']; ?>"/>
                            <p class="description">Enter you payhere secret code as it on you payhere profile</p></td></tr>
                    <tr><td colspan="2"><input type="hidden" name="action" value="payhere_submit_hidden"/>
        <?php echo submit_button('Update Setting'); ?></td></tr>
                    <tr><td colspan="2"><p class="WarningMsg"><?php if($msg=="success"){
                            echo '<p class="MsgSuccess">Information successfully saved</p>';
                    }elseif($msg=="fail") {
                            echo '<p class="MsgFail">Information not saved</p>';
                    }
                    ?></p></td></tr>
                </table>
            </form>
        <?php
    }
}
?>