<?php
class cqCustomSearch {

    private $plugin_name = 'cq-custom';

    public static function init() {
        $self = new self();
        add_action( 'wp_footer', array( $self, 'search_popup_html_fs') );
    }

    public function search_popup_html_fs() {
        echo '<div class="search-box-fs">
				<div class="search-popup-container">
					
					<form role="search" method="get" action="' . home_url( '/' ) . '" id="full-screen-search-form">
						<div id="full-screen-search-container">
							<input type="text" name="s" placeholder="Type and hit enter" id="full-screen-search-input" />
						</div>
					</form>
					
					
                </div>
            </div>
        <div class="search-popup-overlay"><a class="close-icon"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         viewBox="0 0 78 78" style="enable-background:new 0 0 78 78;" xml:space="preserve">
        <style type="text/css">
            .st0{fill:none;stroke:#a1234a;stroke-width:15;stroke-linecap:round;stroke-miterlimit:10;}
        </style>
        <line class="st0" x1="76.5" y1="1.5" x2="1.5" y2="76.5"/>
        <line class="st0" x1="1.5" y1="1.5" x2="76" y2="76"/>
        </svg></a></div>';
    }
}
cqCustomSearch::init();