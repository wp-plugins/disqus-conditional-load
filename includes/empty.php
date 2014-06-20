<?php
/*
* Added for replacing comment template
*/
		 
$type = get_option('type');
if($type=='click'): ?>
<button onclick='load_disqus();'>Load Comments</button>
<div id='disqus_thread'></div>
<?php
endif;
if($type=='scroll'): ?>
<div id='disqus_thread'></div>
<?php
endif;
?>