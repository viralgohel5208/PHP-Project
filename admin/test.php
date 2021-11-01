<?php require_once('Connections/crm.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//$quote_id = 1;
mysql_select_db($database_sp, $sp);
$query_rsQuote = "SELECT     quotes.*     , customer_master.cm_companyname FROM     quotes     LEFT JOIN customer_master          ON (quotes.quote_cm_id = customer_master.cm_id) WHERE (quotes.quote_id  =  $quote_id)";
$rsQuote = mysql_query($query_rsQuote, $sp) or die(mysql_error());
$row_rsQuote = mysql_fetch_assoc($rsQuote);
$totalRows_rsQuote = mysql_num_rows($rsQuote);

mysql_select_db($database_sp, $sp);
$query_QuoteConstructions = "SELECT
    quote_construction.qc_const_id
    , construction_materials.constru_material_material
    , quote_construction.qc_quote_id
FROM
    quote_construction
    LEFT JOIN construction_materials 
        ON (quote_construction.qc_const_id = construction_materials.constru_material_id)
WHERE (quote_construction.qc_quote_id = $quote_id)";
$QuoteConstructions = mysql_query($query_QuoteConstructions, $sp) or die(mysql_error());
$row_QuoteConstructions = mysql_fetch_assoc($QuoteConstructions);
$totalRows_QuoteConstructions = mysql_num_rows($QuoteConstructions);

mysql_select_db($database_sp, $sp);
$query_QuoteProducts = "SELECT * FROM quote_products WHERE quote_products.qp_quote_id = $quote_id ORDER BY qp_id";
$QuoteProducts = mysql_query($query_QuoteProducts, $sp) or die(mysql_error());
$row_QuoteProducts = mysql_fetch_assoc($QuoteProducts);
$totalRows_QuoteProducts = mysql_num_rows($QuoteProducts);

mysql_select_db($database_sp, $sp);
$query_AllTerms = "SELECT
    terms_conditions.*
    , quote_to_term.qt_term_quote_id
FROM
    quote_to_term
    LEFT JOIN terms_conditions 
        ON (quote_to_term.qt_term_term_id = terms_conditions.terms_id)
WHERE (quote_to_term.qt_term_quote_id =$quote_id)";
$AllTerms = mysql_query($query_AllTerms, $sp) or die(mysql_error());
$row_AllTerms = mysql_fetch_assoc($AllTerms);
$totalRows_AllTerms = mysql_num_rows($AllTerms);
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td rowspan="2" align="left" valign="top"><img src="images/final_logo.jpg" alt="sp Logo" width="250" height="150" /></td>
    <td align="right" valign="top"><p align="right">Factory 24, 17-23 Keepel Drive<br />
      Hallam, Victoria 3803<br />
      <strong>T</strong>: + 61 3  9703 1003 <strong>F</strong>: + 61 3 9702 3994 <br/>
        <strong>E</strong>: info@swisspack.com.au <br/>
    www.swisspack.com.au</p>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top"><span style="font-size:xx-large;"><strong><br />QUOTATION</strong></span></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Issue Date</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo date(PHP_DATE, strtotime($row_rsQuote['quote_date'])); ?></strong></td>
        <td align="right" valign="top" style="font-size:28px;"><span class="blacktext">Quotation Number</span></td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_id']; ?></strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Company</td>
        <td colspan="3" align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['cm_companyname']; ?></strong></td>
        </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Product Description</td>
        <td colspan="3" align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_product_desc']; ?></strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Product to Pack</td>
        <td colspan="3" align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_product_to_pack']; ?></strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Construction</td>
        <td colspan="3" align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><?php if($totalRows_QuoteConstructions > 0) { ?>
        <strong><?php do { ?><?php echo str_replace("μ","&micro;",$row_QuoteConstructions['constru_material_material'])."/"; ?><?php } while($row_QuoteConstructions = mysql_fetch_assoc($QuoteConstructions)); ?></strong>
        <?php } ?></td>
      </tr>
      
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Bag Width</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_bag_width']; ?></strong>&nbsp;<strong><?php echo $row_rsQuote['quote_bag_width_measure']; ?></strong></td>
        <td align="right" valign="top" style="font-size:28px;">Bag Length</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_bag_length']; ?></strong>&nbsp;<strong><?php echo $row_rsQuote['quote_bag_length_measure']; ?></strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Bag Gusset</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_bag_gusset']; ?></strong>&nbsp;<strong><?php echo $row_rsQuote['quote_bag_gusset_measure']; ?></strong></td>
        <td align="right" valign="top" style="font-size:28px;">Bag Style</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_bag_style']; ?></strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Zip Lock:</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong>
            <?php if($row_rsQuote['quote_ziplock'] == 1){ echo "YES";} else {echo "NO";} ?>
          </strong></td>
        <td align="right" valign="top" style="font-size:28px;">Tear Notch:</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong>
            <?php if($row_rsQuote['quote_tear_notch'] == 1){ echo "YES";} else {echo "NO";} ?>
          </strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Total Plates</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_total_plates']; ?></strong></td>
        <td align="right" valign="top" style="font-size:28px;">Round Corners:</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong>
          <?php if($row_rsQuote['quote_round_corners'] == 1){ echo "YES";} else {echo "NO";} ?>
        </strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Spout:</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong>
          <?php if($row_rsQuote['quote_spout'] == 1){ echo "YES";} else {echo "NO";} ?>
          </strong></td>
        <td align="right" valign="top" style="font-size:28px;">Mexican Hat:</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong>
          <?php if($row_rsQuote['quote_mexican_hat'] == 1){ echo "YES";} else {echo "NO";} ?>
          </strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Hang Hole:</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong>
          <?php if($row_rsQuote['quote_hang_hole'] == 1){ echo "YES";} else {echo "NO";} ?>
          </strong></td>
        <td align="right" valign="top" style="font-size:28px;">Valve:</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong>
          <?php if($row_rsQuote['quote_valve'] == 1){ echo "YES";} else {echo "NO";} ?>
          </strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Plate Charge/Colour</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong>
          <?php  if($row_rsQuote['quote_plate_charge_measure'] == '$') { echo '$'; } echo number_format($row_rsQuote['quote_plate_charge'], 2); if($row_rsQuote['quote_plate_charge_measure'] != '$') { echo ' cents'; } ?>
        </strong></td>
        <td align="right" valign="top" style="font-size:28px;">&nbsp;</td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;"><strong>Quantity</strong></td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_QuoteProducts['qp_qty']; ?></strong></td>
        <td align="right" valign="top" style="font-size:28px;"><strong>Price Per Bag</strong></td>
        <td align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php if($row_QuoteProducts['qp_price_measure'] == '$') { echo '$'; } echo number_format($row_QuoteProducts['qp_price'], 2); if($row_QuoteProducts['qp_price_measure'] != '$') { echo ' cents'; }?></strong></td>
      </tr>
      <tr>
        <td align="right" valign="top" style="font-size:28px;">Packaging Details</td>
        <td colspan="3" align="left" valign="top" style="color:#0069B8;font-size:28px;" height="30px"><strong><?php echo $row_rsQuote['quote_packing_details']; ?></strong></td>
        </tr>
    </table>    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="font-size:20px;"><strong><u>Terms &amp; Conditions:</u></strong><br />
    		<ul>
              <?php if ($totalRows_AllTerms > 0) { // Show if recordset not empty ?>
                <?php do { ?>
                <li><?php echo $row_AllTerms['terms_content']; ?></li>
                  <?php } while ($row_AllTerms = mysql_fetch_assoc($AllTerms)); ?>
                <?php } // Show if recordset not empty ?>
            </ul>
        <p style="color: #FF0000;font-weight:bold;">All artwork must be sent in  original .eps (illustrator) format with all layers outlined/original files with  fonts and separated layers only created in .eps format.</p>    </td>
  </tr>
</table>
<?php
mysql_free_result($rsQuote);

mysql_free_result($AllTerms);
?>