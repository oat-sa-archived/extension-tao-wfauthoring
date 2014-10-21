<?php
use oat\tao\helpers\Template;

Template::inc('form_context.tpl', 'tao');
?>
<header class="section-header flex-container-full">
    <h2><?=get_data('formTitle')?></h2>
</header>
<div class="main-container flex-container-main-form">
    <div class="form-content">
        <?=get_data('myForm')?>
    </div>
</div>

<script type="text/javascript">
function disableInput($input){
	// $input.attr('disabled', 'disabled').hide();
	$input.hide();
}

function enableInput($input){
	// $input.attr('disabled', '').show();
	$input.show();
}

function switchACLmode(){
	var restrictedUserElt = $('select[id=\'<?=tao_helpers_Uri::encode(PROPERTY_PROCESS_INIT_RESTRICTED_USER)?>\']').parent();
	var restrictedRoleElt = $('select[id=\'<?=tao_helpers_Uri::encode(PROPERTY_PROCESS_INIT_RESTRICTED_ROLE)?>\']').parent();
	var mode = $('select[id=\'<?=tao_helpers_Uri::encode(PROPERTY_PROCESS_INIT_ACL_MODE)?>\']').val();

	if(mode == '<?=tao_helpers_Uri::encode(INSTANCE_ACL_USER)?>'){//mode "user"
		enableInput(restrictedUserElt);
		disableInput(restrictedRoleElt);
	}else if(mode == ''){
		disableInput(restrictedRoleElt);
		disableInput(restrictedUserElt);
	}else{
		enableInput(restrictedRoleElt);
		disableInput(restrictedUserElt);
	}
}

$(document).ready(function(){
	switchACLmode();
	$('select[id=\'<?=tao_helpers_Uri::encode(PROPERTY_PROCESS_INIT_ACL_MODE)?>\']').change(switchACLmode);
});
</script>
<?php
Template::inc('footer.tpl');
?>
