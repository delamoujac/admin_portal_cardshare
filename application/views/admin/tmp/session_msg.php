<?php
$smsg = $this->session->userdata('msg');
$eres = $this->session->userdata('res');
if($smsg!='') { ?>  
<div class="<?php if($eres==0) {  echo $h= 'notibar msgerror'; }
if($eres==1){ echo $h='notibar msgsuccess'; } ?>"><?php if(! is_null($smsg)) echo "<a href='#' class='close'></a>"; echo '<p>'.$smsg.'</p>'; 
$this->session->unset_userdata('msg');
$this->session->unset_userdata('res'); ?></div>
<?php  } ?>
<?php if(validation_errors()) { ?>
      <div class="notibar msgalert">  <a class="close"></a><p><?php echo validation_errors(); ?></p> </div>
      <?php } ?>

