<header class="dashboard-header">
  <div class="container">
    <div class="row-fluid dashboard-header">
      <div class="col-md-12">
        <h1>Current Job Listings</h1>
      </div>
    </div>
  </div>
</header>
<div class="container dashboard-content" id="lot-submit">
	<div class="row">
		<div class="col-md-12">	
	    <?php do_action('get_current_job_listings');  ?>
		</div>
	</div>
</div>