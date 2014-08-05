<?php
/*
* Added for replacing comment template
*/
$click_hide = get_option('click_hide');
if ($click_hide == 'yes'):
    ?>
    <script type='text/javascript'>
			var button = document.getElementById('js_comment_div')
			button.addEventListener('click', hideshow, false);

        function hideshow() {
            document.getElementById('hidden-div').style.display = 'block';
            this.style.display = 'none'
        }
    </script>
    <?php
 endif;
