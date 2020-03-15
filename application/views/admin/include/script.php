<!-- script for crop image -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<script src="<?=base_url('crop');?>/dist/cropper.min.js"></script>
<script src="<?=base_url('crop');?>/js/main.js"></script>

<!-- jQuery 2.2.0 -->
<script src="<?=base_url('assets/admin');?>/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_url('assets/admin');?>/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

<!-- FastClick -->
<script src="<?=base_url('assets/admin');?>/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets/admin');?>/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url('assets/admin');?>/dist/js/demo.js"></script>

<script src="<?=base_url('assets/admin');?>/dist/js/active.js"></script>
<!-- page script -->



<script type="text/javascript">
var themestyle = $('.themestyle').attr('href');

$(function () {
	$('.box-par-btn').click(function(){
		$('.themestyle').attr('href', 'dist/css/skin-red.css')
	})

	$('.box-par1-btn').click(function(){
		$('.themestyle').attr('href', 'dist/css/skin-blue.css')
	})
})
	


</script>

