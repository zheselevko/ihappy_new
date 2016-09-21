

<?php if (count($currencies) > 1) {  ?>

<select data-cur="<?php echo $this_cur; ?>" id="cur_sel" class="currency" >



    <?php foreach ($currencies as $currency) { ?>

  <option <?if($currency['code']==$this_cur){echo "selected"; }?> value="<?php echo $currency['code']; ?>" >

  <?php echo $currency['code']; ?></option>

  <?php } ?>

  

</select>

<form id="form-currency" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

 <input type="hidden" name="code" value="" />

 <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />

</form>

<script>

$("#cur_sel").change(function(){

$('#form-currency input[name=\'code\']').attr('value', $("#cur_sel option:selected").val());



$('#form-currency').submit();

});



</script>



<? }?>

