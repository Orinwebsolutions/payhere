<?php
//require_once ( dirname(__FILE__) . '/payhere-connect.php' );

//functionPayhereForm(); //

function functionPayhereForm() {//
    ob_start()
        ?>
<div id="payhereCustomerdetails"><h2>Customer details</h2><hr/> 
<!--    <form name="payCusForms" id="payCusForms" action="" method="post">-->
<!--    <form name="payCusForms" id="payCusForms" action="">        -->
                <table>
                    <tr>
                        <td><label>First Name</label></td>
                        <td><input type="text" name="fName" id="fName" size="50" /></td>
                    </tr>
                    <tr>
                        <td><label>Last Name</label></td>
                        <td><input type="text" name="lName" id="lName" size="50"/></td>
                    </tr>
                    <tr>
                        <td><label>Email</label></td>
                        <td><input type="text" name="eMail" id="eMail" size="50"/></td>
                    </tr>
                    <tr>
                        <td><label>Phone No</label></td>
                        <td><input type="text" name="phoneNo" id="phoneNo" size="50"/></td>
                    </tr>
                    <tr>
                        <td><label>Address</label></td>
                        <td><textarea cols="5" rows="10" name="address" id="address"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button id="PayhereSubmitForm">Submit your payment</button>
                        </td>
<!--                            <input type="hidden" name="action" value="payhere_form_hidden"/>
                            <input type="submit" value="<?php //_e('Submit your payment'); ?>"/></td>-->
                    </tr>
                </table>
<!--            </form>-->
    </div>
        <?php
        	return ob_get_clean();
}
?>