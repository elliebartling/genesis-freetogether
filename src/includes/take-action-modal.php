<?php


//* Hook after after content
add_action( 'genesis_after_content', 'ft_take_action_modal' );
function ft_take_action_modal() {

	$before = '';
	$before .= '<div class="modal take-action-modal" tabindex="-1" role="dialog" id="takeAction">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">Take Action</h4>
				      </div>
				      <div class="modal-body">
				        <p>Enter your zipcode and email below, and we’ll match you with an organization that’s working on issues in your state.</p>
				      </div>
				      <div class="modal-footer">';
	$after = '';
	$after .= '</div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->';
	
	genesis_widget_area( 'email-capture-modal', array(
		'before' => $before,
		'after' => $after
	) );


}


?>