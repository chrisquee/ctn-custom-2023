<header class="dashboard-header">
  <div class="container">
    <div class="row-fluid dashboard-header">
      <div class="col-md-12">
        <h1><?php echo isset($_GET['action']) && $_GET['action'] == 'edit' ? 'Edit an item' : 'Add a new business'; ?></h1>
      </div>
    </div>
  </div>
</header>
<div class="container dashboard-content" id="lot-submit">
	<div class="row">
		<div class="col-md-12">
	
			<?php  do_action('setup_business_new_form'); ?>
			
		</div>
	</div>
</div>
