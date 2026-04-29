<?php

class cqNewsletter {
    
    public static function init() {
    	$self = new self();
        add_action( 'wp_ajax_submit_cq_newsletter_signup_form', array($self, 'submit_cq_newsletter_signup_form') );
        add_action( 'wp_ajax_nopriv_submit_cq_newsletter_signup_form', array($self, 'submit_cq_newsletter_signup_form') );
        //add_action( 'wp_footer', array($self, 'force24_js'), 100 );
        //add_action( 'wp_head', array($self, 'setup_onesignal_overrides'), 100);
        add_action( 'wp_head', array($self, 'force24_v3_js'), 99);
        add_action( 'wp_head', array($self, 'hotjar_js'), 99);
        add_shortcode('cq_newsletter_form', array($self, 'cq_add_newsletter_form') );
        add_action('admin_menu', array($self, 'add_newsletter_export_page'));
        add_action('admin_post_cq_export_newsletter_csv', array($self, 'cq_export_newsletter_csv'));
  	}
    
    public function cq_add_newsletter_form($attributes) {
        $cq_adestra_atts = shortcode_atts(array(
          'campaign_id' => '1936'), $attributes);

        $cq_signup_html = '
                    <div class="cq-container">
                        <form id="newsletter_form" class="newsletter-form" action="' . get_site_url() . '/wp-admin/admin-ajax.php" method="POST">
                            <input class="rce-contact-control required email" type="email" name="newsletter_email" placeholder="you@yourdomain.com" />
                            <button class="button button-category button-fill button-small newsletter_submit" type="submit" id="newsletter_submit"><span class="hidden-md-down">Submit</span> <span class="material-symbols-outlined">chevron_right</span></button>
                        </form>
                        <small>By providing your email address you consent to us sending you information by email. For more information see our <a href="' . get_permalink(get_page_by_path('privacy-policy')) . '">privacy policy</a>.</small>
                        <div class="vc-newsletter-submit-result"></div>
                    </div>';
        
         return $cq_signup_html;
    }
    
    public function submit_cq_newsletter_signup_form() {
        
        global $wpdb;

        check_ajax_referer('ajax-login-nonce', 'security');

        $table = $wpdb->prefix . 'cq_newsletter_submissions';

        $data = $_REQUEST['data'] ?? [];

        if (empty($data)) {
            echo '<p class="newsletter-message error">No data received.</p>';
            wp_die();
        }

        $timestamp = date("Y-m-d H:i:s") . '.' . str_pad(gettimeofday()['usec'], 6, '0', STR_PAD_LEFT); // keeps consistency
        $form_name = 'newsletter_signup';

        foreach ($data as $field) {

            if (!isset($field['name'], $field['value'])) {
                continue;
            }

            $name = sanitize_text_field($field['name']);
            $value = sanitize_text_field($field['value']);

            if ($name === 'newsletter_email') {
                $email = $value;
            }

            $wpdb->insert(
                $table,
                [
                    'submission_timestamp' => $timestamp,
                    'form_name'           => $form_name,
                    'field_name'          => $name,
                    'field_value'         => $value,
                    'file'                => null,
                    'exported'           => 0,
                ],
                [
                    '%s','%s','%s','%s','%s','%d'
                ]
            );
        }

        // keep your existing UI logic
        echo '<p class="newsletter-message success">You have been successfully subscribed.</p>';

        wp_die();
            
            /* $subscribe = 1;

            if ($subscribe == 1) {
                echo '<p class="newsletter-message success">You have been successfully subscribed.</p>';
            } else if ($subscribe == 2) {
                echo '<p class="newsletter-message success">Your details have been updated.</p>';
            } else {
                echo '<p class="newsletter-message error">An error occured please try later.</p>';
            }
        }

        die();	 */
    }

    public function add_newsletter_export_page() {
        add_menu_page(
            'Newsletter Signups',
            'Newsletter Signups',
            'manage_options',
            'cq-newsletter-export',
            array($this, 'cq_render_newsletter_export_page'),
            'dashicons-download',
            25);
    }

    public function cq_render_newsletter_export_page() {
        ?>
        <div class="wrap">
            <h1>Newsletter Signups Export</h1>

            <p>Download all newsletter submissions as a CSV file.</p>

            <a href="<?php echo admin_url('admin-post.php?action=cq_export_newsletter_csv'); ?>"
            class="button button-primary">
                Download CSV
            </a>
        </div>
        <?php
    }

    public function cq_export_newsletter_csv() {

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        global $wpdb;

        $table = $wpdb->prefix . 'cq_newsletter_submissions';

        $rows = $wpdb->get_results("
            SELECT *
            FROM $table
            ORDER BY submission_timestamp DESC, id ASC
        ", ARRAY_A);

        // group submissions
        $grouped = [];

        foreach ($rows as $row) {

            $key = $row['form_name'] . '|' . $row['submission_timestamp'];

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'submission_timestamp' => $row['submission_timestamp'],
                    'form_name' => $row['form_name']
                ];
            }

            $field = $row['field_name'];
            $value = $row['field_value'];

            $grouped[$key][$field] = $value;
        }

        // collect all possible columns dynamically
        $columns = ['submission_timestamp', 'form_name'];

        foreach ($grouped as $submission) {
            foreach ($submission as $key => $val) {
                if (!in_array($key, $columns)) {
                    $columns[] = $key;
                }
            }
        }

        // output CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="newsletter-export.csv"');

        $output = fopen('php://output', 'w');

        // header row
        fputcsv($output, $columns);

        // data rows
        foreach ($grouped as $submission) {

            $row = [];

            foreach ($columns as $col) {
                $row[] = $submission[$col] ?? '';
            }

            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }
    
    public function force24_v3_js() {
        ?>
        
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TXFCM3NW');</script>
        <!-- End Google Tag Manager -->
        
        <?php
    }
    
    public function hotjar_js() {
        ?>

        <!--  Hotjar Tracking Code for Cruise Trade News -->
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:4946765,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
        <!--  END Hotjar Tracking Code for Cruise Trade News -->
        
        <?php
    }
    
    public function force24_js() {
        
        ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-45673473-6" type="text/javascript"></script>
        <script type="text/javascript">
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments)};
          gtag('js', new Date());

          gtag('config', 'UA-45673473-6', { 'anonymize_ip': true });
        </script>

        <!-- Google tag (gtag.js) --> 
        <script async src=https://www.googletagmanager.com/gtag/js?id=G-SJFJXPHSQW></script>
        <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-SJFJXPHSQW'); </script>

        <script type="text/javascript">
        !function(f,o,r,c,e,_2,_4){f.Force24Object=e,f[e]=f[e]||function(){ (f[e].q=f[e].q||[]).push(arguments)},f[e].l=1*new Date, _2=o.createElement(r),_4=o.getElementsByTagName(r)[0],_2.async=1, _2.src=c,_4.parentNode.insertBefore(_2,_4)}(window,document, "script","//tracking1.force24.co.uk/tracking/V2/main.min.js","f24");
        /* Set clientId */
        f24("create", "98fb23b8-79f2-49ed-9b8b-5d985a8d0c18"); /* Place custom commands here */
        f24("cookieAnonymous", true);
        f24("send", "pageview");
        f24("formSubmitAfterTracking", false);

        var wpcf7Elm = document.querySelector('.wpcf7');
        if (wpcf7Elm) {
            wpcf7Elm.addEventListener( 'wpcf7mailsent', function( event ) {
                // force disable submitAfterTracking for CF7 forms
                var setting = f24("settings").form.submitAfterTracking;
                var f24submitted = false;
                f24("formSubmitAfterTracking", false);

                setTimeout(function() {
                    f24("send", "form", jQuery(this).find("form"), function () {
                        f24("formSubmitAfterTracking", setting);
                    });

                    cf7redirect();

                }, 3000);
                f24("send", "form", jQuery(this).find("form"), function () {
                    f24("formSubmitAfterTracking", setting);
                });

            }, false );
        }

        var contact_submit = document.querySelector('#contact_submit');
        if (contact_submit) {
            contact_submit.addEventListener( 'contact_submitter', function( event ) {

                var setting = f24("settings").form.submitAfterTracking;
                var f24submitted = false;
                f24("formSubmitAfterTracking", false);

                f24("send", "form#contact_submit", jQuery(this).find("form#contact_submit"), function () {
                    f24("formSubmitAfterTracking", setting);
                });

            }, false );
        }

        function cf7redirect() {
            var thankyouURL = document.getElementById("thankyouURL").value;
            location = thankyouURL;
        }
        </script>


        <script type="text/javascript">
        //f24("formSelector", "form.newsletter-form"); 
        f24("formMap", [
         {
          selector: "form.newsletter-form",
          meta: { f24name:"newsletter-form"},
          fields: {
            "EmailAddress": "newsletter_email"
           },
           marketingList: "393baa4e-71fc-467b-ac46-e87efa36c55f"
         },
         {
          selector: "form#fred-olsen-registration",
          meta: { f24name:"fred-olsen-registration"},
          fields: {
            "FirstName": "text-first-name",
            "LastName": "text-last-name",
            "CompanyName": "company_name",
            "EmailAddress": "email_address"
           },
           marketingList: "62427025-694b-4041-9353-156526987a6f"
         },
         {
          selector: "form#ctn-clia-registration",
          meta: { f24name:"ctn-clia-registration"},
          fields: {
            "FirstName": "text-first-name",
            "LastName": "text-last-name",
            "CompanyName": "company_name",
            "EmailAddress": "email_address"
           },
           marketingList: "c0201d03-d4b8-487a-afdd-1cc8bf4fb5ab"
         },
         {
          selector: "form#contact_submit",
          meta: { f24name:"contact_submit"},
          fields: {
            "FirstName": "entry_firstname",
            "LastName": "entry_lastname",
            "CompanyName": "entry_company",
            "EmailAddress": "email_address"
           },
           marketingList: "62427025-694b-4041-9353-156526987a6f"
         },
         {
          selector: "form#qatar_form",
          meta: { f24name:"qatar-entry-form"},
          fields: {
            "FirstName": "first_name",
            "LastName": "last_name",
            "CompanyName": "agency_name",
            "EmailAddress": "email_address"
           },
           marketingList: "682567e2-d93a-4f76-b2d2-3e533eb1f85e"
         }
        ]);
        </script>
        <?php
        
    }
    
    public function setup_onesignal_overrides () {
        ?>

        <script>
            window.OneSignal = window.OneSignal || [];
            window.OneSignal.push(function() {
            OneSignal.SERVICE_WORKER_UPDATER_PATH = "OneSignalSDKUpdaterWorker.js";
            OneSignal.SERVICE_WORKER_PATH = "OneSignalSDKWorker.js";
            OneSignal.SERVICE_WORKER_PARAM = { scope: '/' };
            delete window._oneSignalInitOptions.path
            window.OneSignal.init(window._oneSignalInitOptions);
          });
        </script>

        <?php
    }
    
}
cqNewsletter::init();