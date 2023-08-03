<header class="dashboard-header">
  <div class="container">
    <div class="row-fluid dashboard-header">
      <div class="col-md-12">
        <h1>Verify your account</h1>
      </div>
    </div>
  </div>
</header>
<div class="container dashboard-content"> 
    <div class="row">
        <div class="col-md-12">
          <h3>Verify your account</h3>

          <p>To be able to add your business to the business directory or post any jobs to the job board, we need to verify you as a user.</p>

          <p>Click below to send a verification email, then enter the verification code in the box below to confirm your user account.</p>

          <p><a href="#" id="user-code-submit" class="submit_company_verification button button-blue" data-nonce="<?php echo wp_create_nonce( 'verify_nonce' ); ?>">Send verification code</a></p>
          
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="verify-container">
                <h4>Enter Code</h4>
                <input type="text" id="user_code" name="business_code" class="verify" />
                <button id="user-verify-submit" class="button button-blue" data-nonce="<?php echo wp_create_nonce( 'user_confirm_nonce' ); ?>">Verify</button>
                <p id="claim-message"></p>
            </div>
        </div>
    </div>
</div>