<script type="text/javascript">
require(['layout/section'], function(section){
    var authoringUrl = "<?=_url('authoring', 'Process', null, array('uri' => get_data('uri'), 'classUri' => get_data('classUri') ))?>";

	<?php if(get_data('uri') && get_data('classUri') && strpos(get_data('module'), 'Process') !== false):?>
		section.get('process_authoring').enable().selected.url = authoringUrl;
	<?php else:?>
		section.get('process_authoring').disable();
	<?php endif?>
});
</script>
