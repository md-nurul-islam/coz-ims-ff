<?php

$this->renderPartial('_form', array(
    'model' => $model,
    'model_config' => $model_config,
    'model_config_data' => $model_config_data,
));
?>

<div class="clearfix"></div>

<script src="//cdn.ckeditor.com/4.5.5/full/ckeditor.js"></script>

<script type="text/javascript">
    CKEDITOR.replace( 'Configurations_value_header_value' );
    CKEDITOR.replace( 'Configurations_value_footer_value' );
</script>