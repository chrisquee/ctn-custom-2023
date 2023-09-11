<header class="dashboard-header">
  <div class="container">
    <div class="row-fluid dashboard-header">
      <div class="col-md-12">
        <h1>My Details</h1>
      </div>
    </div>
  </div>
</header>
<div class="container dashboard-content">
    <div id="notices">
        <?php do_action('show_notices');  ?>
    </div>
<?php do_action( 'cq_show_messages'); ?>
<?php do_action( 'cq_before_profile_fields', '', get_current_user_id() ); ?>

<form method="post" action="#" class="cq-user-form">
	<div class="container dashboard-content"> 
		<?php output_user_fields(); ?>

		<?php do_action( 'cq_after_profile_fields', '', get_current_user_id() ); ?>
    </div>
</form> 

<?php do_action( 'cq_after_profile', '', get_current_user_id() ); ?>
</div>