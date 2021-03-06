<h1>Registrant Info:</h1>

<div class="form_row">
<div class="form_cell">
<table class="indent">
    <tr>
    <td class="no_brder"><label for="ordernumber">PayPal Unique Transaction ID</label><br /><input type='text' id='ordernumber' name='ordernumber' value='<?php echo $ordernumber ?>'></td>
    <td class="no_brder"><label for="timestamp">Transaction Timestamp</label><br /><input type='text' id='timestamp' name='timestamp' value='<?php echo $created_at ?>'></td>
    </tr>
</table>
<h2>Contact Information</h2>

<table class="indent">
    <tr>
    <td class="no_brder"><label for="FirstName">* First Name</label><br /><input class="validate[required] text-input" type='text' id='FirstName' name='shipTo_firstName' value='<?php echo $first_name ?>'></td>
    <td class="no_brder"><label for="">* Last Name</label><br /><input class="validate[required] text-input" type='text' id='LastName' name='shipTo_lastName' value='<?php echo $last_name ?>'></td>
    <td class="no_brder"><label for="">Affiliation</label><br /><input type='text' name='affiliation' value='<?php echo $affiliation ?>'></td>
    </tr>
    <tr>
      <td class="no_brder"><label for="">* Email</label><br /><input class="validate[required,custom[email]]" type='text' id='email' name='billTo_email' value='<?php echo $email ?>'></td>
    </tr>
    <tr>
      <td class="no_brder"><label for="">Address 1</label><br /><input type='text' id='Addr1'  name='shipTo_street1' value='<?php echo $address1 ?>'></td>
      <td class="no_brder"><label for="">Address 2</label><br /><input type='text' id='Addr2' name='shipTo_street2' value='<?php echo $address2 ?>'></td>
    </tr>
    <tr>
    <td class="no_brder"><label for="">City</label><br /><input type='text' id='City' name='shipTo_city' value='<?php echo $city ?>'></td>
    <td class="no_brder"><label for="">State</label><br /><input type='text' id='State' name='shipTo_state' value='<?php echo $state ?>'></td>
    <td class="no_brder"><label for="">Zip</label><br /><input type='text' id='ZipCode' name='shipTo_postalCode' value='<?php echo $postal_code ?>'></td>
   </tr>
    <tr>
      <td class="no_brder"><label for="">Country</label><br />

        <select id='Country' name="shipTo_country" size="1" style="width:150px">
            <?php foreach ($countries as $key => $shipTo_country) {
            echo "<option value=\"$key\"";
                        if ($key == $country)
              {
                echo " selected";
              }
              echo ">$shipTo_country</option>";
            } ?></select>
    </td>
    </tr>
</table>

</div>
<div class="form_cell">
<h2>Registered Sessions:</h2>

<p>Registered at <span class="highlight"><?php echo "$type" ?></span> level on <span class="bold"><?php echo "$reg_date" ?></span>, for the following sessions:

<table class="schedule">
  <tr>
    <th colspan="2">Session </th>
    <th>Dates</th>
  </tr><?php echo $display_sessions ?>
  <tr>
    <td colspan="6"><span class="asterisk_text">*SciPy 2013 Sprints will be free of cost to everyone. However, for catering purposes, we would like to know whether you plan on attending.</span></td>
</table>


</div>
</div>

<div class="row">
<div class="cell">
<h2> Participant Level </h2>
<table align="center" width="250"  class="schedule">
<tr><th colspan="2">Level:</th></tr>
    <?php echo $display_participants ?>
</table>
</div>
<div class="cell">

<h2>T-Shirt Preference</h2>

<table align="center" width="250" class="schedule">
<tr><th colspan="2">Type:</th></tr>
    <?php echo $display_types ?>
</table>

<table align="center" width="250" class="schedule">
<tr><th colspan="2">Size:</th></tr>
    <?php echo $display_sizes ?>
</table>
<?php 
  if ($promotion_id != "")
    {
      echo "<input type=\"hidden\" name=\"promotion_id\" value=\"$promotion_id\" />";
    }
?>
</div>
</div>
<div style="clear:both;"></div>
<br />


