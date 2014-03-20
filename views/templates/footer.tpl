<script type="text/javascript">
require(['helpers', 'uiBootstrap'], function(helpers, uiBootstrap){
	<?if(get_data('uri') && get_data('classUri') && strpos(get_data('module'), 'Process') !== false):?>
		helpers.updateTabUrl(uiBootstrap.tabs, 'process_authoring', "<?=_url('authoring', 'Process', null, array('uri' => get_data('uri'), 'classUri' => get_data('classUri') ))?>");
	<?else:?>
		var tabindex = helpers.getTabIndexByName('process_authoring');
		if (tabindex != -1) {
			uiBootstrap.tabs.tabs('disable', tabindex);
		}
	<?endif?>

  //  uiBootstrap.initTrees();
});
</script>
