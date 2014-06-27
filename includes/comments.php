<?php
/*
 * Added for replacing comment template
 */

$type = get_option('type');
$click_hide = get_option('click_hide');
if (get_option('button')) {
    $button = get_option('button');
}
else {
    $button = 'Load Comment';
}
if(comments_open()):
if ($type == 'click'):
    ?>
    <div id='hidden-div' align='center'><button id='js_comment_div' onclick='load_disqus();'><?php echo $button; ?></button></div>
    <div id='disqus_thread'></div>
    <?php
endif;
if ($type == 'scroll'):
    ?>
    <div id='disqus_thread'></div>
    <?php
endif;
endif;
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