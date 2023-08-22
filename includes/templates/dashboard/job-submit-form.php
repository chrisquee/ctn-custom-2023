<?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
<div id="notices" class="container">
	<ul id="user-notices">
        <li class="notice success">Updated!</li>
    </ul>    
</div>
<?php } ?> 

<?php if (isset($job->job_page_link) && $job->job_page_link !== '') { ?>
<div id="updated-container-link" class="container">
	<div class="updated-container">
		<a href="<?php echo esc_url($job->job_page_link); ?>" target="_blank" class="button button-ghost button-white"><span class="material-symbols-outlined">link</span> <?php echo esc_url($job->job_page_link); ?></a>
    </div>    
</div>
<?php } ?>

<div id="form-container" class="container">
  <form id="profile_form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" accept-charset="UTF-8">
  <div class="company-wrap cf"> 
  <div class="row cf">
  	<div class="col-md-12">
  		<h4>Job Details</h4>
    </div>
  </div>      
  <?php if ($job) { ?>
    <input type="hidden" id="action" name="action" value="<?php echo $action; ?>" />
    <input type="hidden" id="redirect" name="redirect" value="<?php echo site_url($_SERVER['REQUEST_URI']); ?>" />
  	<input type="hidden" id="job_id" name="job_id" value="<?php echo $job->job_id; ?>" />
    <input type="hidden" id="employer_id" name="employer_id" value="<?php echo $user_id; ?>" />
  <?php } ?>
      
  	<div class="row cf">
    	<div class="col-md-6">
            <div class="form-group">
              <label for="name">Job Title</label>
              <input type="text" class="form-control" id="job_title" name="job_title" aria-describedby="emailHelp" placeholder="Job Title" value="<?php echo $job->job_title; ?>" required />
             </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label for="company_type_id">Job Location</label>
              <input type="text" class="form-control" id="job_location" name="job_location" aria-describedby="emailHelp" placeholder="eg: London, UK" value="<?php echo $job->job_location; ?>" required />
             </div>
        </div>
    </div>
      
    <div class="row cf">
    	<div class="col-md-6">
            <div class="form-group">
              <label for="name">Company Name</label>
              <input type="text" class="form-control" id="job_company_name" name="job_company_name" aria-describedby="emailHelp" placeholder="Job Title" value="<?php echo $job->job_company; ?>" required />
             </div>
        </div>
    </div>
    
    <div class="row">
    	<div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Job Scope</label>
              <input type="text" class="form-control" id="job_scope" name="job_scope" aria-describedby="emailHelp" placeholder="eg: Full time" value="<?php echo $job->job_scope; ?>" required />
             </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Job Type</label>
              <select class="form-control" id="job_type" name="job_type" aria-describedby="emailHelp" required >
                    <?php echo $job->get_job_type_options($job->job_type_id); ?>
              </select>
             </div>
        </div>
    </div>
      
    <div class="row">
    	<div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Job application URL</label>
              <input type="text" class="form-control" id="job_url" name="job_url" aria-describedby="emailHelp" placeholder="https://www.domain.com" value="<?php echo $job->job_url; ?>" />
             </div>
        </div>
    	<div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Job application email</label>
              <input type="text" class="form-control" id="job_email" name="job_email" aria-describedby="emailHelp" placeholder="email@domain.com" value="<?php echo $job->job_email; ?>" />
             </div>
        </div>
     </div>
     
     <div class="row">
    	<div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Job Introduction</label>
              <textarea class="form-control" id="job_introduction" name="job_introduction" rows="3" placeholder="Add a brief introduction" style="white-space: pre-wrap;"><?php echo trim(strip_tags($job->job_description)); ?></textarea>
             </div>
        </div>
     </div>
     <div class="row">
    	<div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Job Description</label>
              <textarea class="form-control" id="job_description" name="job_description" rows="10" placeholder="Add your job description" style="white-space: pre-wrap;" /><?php echo trim(strip_tags($job->job_full_description)); ?></textarea>
             </div>
        </div>
     </div>
     <div class="row">
    	<div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Application Instructions</label>
              <textarea class="form-control" id="application_instructions" name="application_instructions" rows="10" placeholder="Add instructions on how to apply" style="white-space: pre-wrap;" /><?php echo $job->application_instructions; ?></textarea>
             </div>
        </div>
     </div>
    </div>

    <?php $nonce = wp_create_nonce( 'ajax-img-upload-nonce' ); ?>
    <div class="category-image-wrap">
        <div class="row cf">
          <div class="col-md-12">
              <h4>Company Image</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="logo_image_id">Add a logo image</label>
                  <?php
                  $logo_id = $job->job_logo;
                    if (is_numeric($logo_id) && $logo_id > 0) {
                        $logo_attributes = wp_get_attachment_image_src( $logo_id );
                        $logo_src = $logo_attributes[0];
                    } else {
                        $logo_src = plugins_url( 'cq-custom/img/no-image.jpg' );
                    }
			    
			    	?>
					<input type="file" name="logo_image" id="logo_image" class="regular-text" accept="image/*" />
                    <input type="hidden" name="logo_image_id" id="logo_image_id" value="<?php echo $job->job_logo; ?>" />
                    <button id="logo-upload" class="button button-blue" data-nonce="<?php echo $nonce; ?>">Add Logo</button>
                    <div class="logo-thumbnail"><img src="<?php echo $logo_src; ?>" id="logo-img"></div>
              </div>
          </div>
        </div>
    </div>
    <div class="upgrade-section no-changes">
            <div class="row cf">
                <div class="col-md-9">
                    <span style="margin: 1.1rem 0;display: block;">
                        <input type="checkbox" value="yes" id="up_to_date" name="up_to_date"> 
                        <label for="up_to_date">Please tick and submit to confirm your details are correct.</label>
                    </span>
                </div>
                <div class="col-md-3" style="text-align: right;">
                    <button type="submit" id="submit_button" class="btn-default btn-submit button-primary button button-blue" style="display: inline-block;" disabled="disabled">Save Changes</button> 
                </div>
            </div>
        </div>
  </form>
</div>
<script>
jQuery("#up_to_date").on('change', function() {
    jQuery("#submit_button").attr("disabled", !this.checked);
});

</script>