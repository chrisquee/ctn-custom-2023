<?php

class cqAdminNotices {
	
	private $message;
    private $type;

	public function __construct( $message, $type = 'info' ) {
		$this->message = $message;
        $this->type = $type;

		add_action( 'admin_notices', array( $this, 'render' ) );
	}
	public function render() {
		printf( '<div class="notice notice-%s is-dismissible"><p>%s</p></div>', esc_attr( $this->type ), esc_html( $this->message ) );
	}
}