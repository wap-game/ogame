<script type="text/javascript">

function calc_resources()

{
	var regain_met = {schrotti_met};
	var regain_crys = {schrotti_crys};
	var regain_deut = {schrotti_deut};
	var max_ships_sell = {max_ships_to_sell};
	var num = parseInt(document.getElementById('numschrotti').value, 10);

	if (num < 0 || isNaN(num)){
		num = 0;
		document.getElementById('numschrotti').value=num;
	}

	if (num > max_ships_sell){
		num = max_ships_sell;
		document.getElementById('numschrotti').value=num;
	}

	document.getElementById('schrotti_met').innerHTML = num * regain_met;
	document.getElementById('schrotti_crys').innerHTML = num * regain_crys;
	document.getElementById('schrotti_deut').innerHTML = num * regain_deut;
}

</script>

<br>
<br>
<center>
  <table border="0" cellpadding="0" cellspacing="1" width="600">
   <tr height="20">
		<td colspan="5" class="c">{Intergalactic_merchant}</td>
	</tr>
     <tr height="10">
    	<th width="120" rowspan="5" align="left" class="c"><img src="{dpath}gebaeude/{image}.gif" width="120" height="120"></th>
    	<th width="300" align="center" class="1">{Merchant_text_decript}</th>
    	<td width="115" align="center" class="c"><br>
				<form name="planets" action="schrotti.php" method="post">
				<select name="shiptypeid" onchange="this.form.submit();">{shiplist}</select>
				</form>	</td>
        <td width="115" align="center" class="c"><span style="color:yellow;">¹²£º{max_ships_to_sell} Ö»</span></td>
     </tr>

	<form action="" method="post">
     <tr height="20">
         <th align="center">{How_much_want_exchange}</th>
         <td colspan="2" align="left" class="c">
         	<input type="hidden" name="shiptypeid" value="{shiptype_id}">
          <input id="numschrotti" type="text" name="number_ships_sell" alt="{Kleiner_transporter}" size="20" maxlength="40" value="0" tabindex="1" onKeyup="calc_resources();"></td>
     </tr>

     <tr height="20">
       <th align="center">{Merchant_give_Info}</th>
		 <td colspan="2" class="c">
		 {Merchant_give_Aluminium}<br>
		 {Merchant_give_Silicium}<br>
		 {Merchant_give_Deuterium}		 </td>
     </tr>

     <tr height="20" align="center">
			<th>&nbsp;</th>
       <td colspan="2" class="c"><input name="submit" type="submit" value="{Exchange}"></td>
     </tr>
</form>
    </table>

</center>
</body>
</html>