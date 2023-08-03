<header class="dashboard-header">
  <div class="container">
    <div class="row-fluid dashboard-header">
      <div class="col-md-12">
        <h1>Claim a business</h1>
      </div>
    </div>
  </div>
</header>
<div class="container dashboard-content"> 
<?php 
    
    global $company;

    do_action('get_company_data', $_GET['business_id']);
    
    //print_r($company);
    
?>
    <div class="row">
        <div class="col-md-12">
          <h3>Claim <?php echo $company->meta['name']; ?></h3>

          <p>To confirm you have the authority to act on this company's behalf, we need to send a verification email to the registered email address we have on file for this business.</p>

          <p>Click below to send a verification email, then enter the verification code in the box below to link your user account with the business profile.</p>

          <p><a href="#" id="code-submit" class="submit_company_verification button button-blue" data-companyid="<?php echo $company->company_id; ?>" data-nonce="<?php echo wp_create_nonce( 'verify_nonce' ); ?>">Send verification code</a></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="verify-container">
                <h4>Enter Code</h4>
                <input type="text" id="business_code" name="business_code" class="verify" />
                <input type="hidden" id="company_id" name="company_id" value="<?php echo $company->company_id; ?>" />
                <button id="verify-submit" class="button button-blue" data-nonce="<?php echo wp_create_nonce( 'business_confirm_nonce' ); ?>">Verify</button>
                <p id="claim-message"></p>
            </div>
        </div>
    </div>
</div>