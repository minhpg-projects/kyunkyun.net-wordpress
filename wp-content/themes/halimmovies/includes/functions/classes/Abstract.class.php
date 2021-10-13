<?php

abstract class HaLim_Abstract {

	public function addAction( $hook, $function_to_add, $priority = 30, $accepted_args = 1 ) {
		add_action( $hook, array( &$this, $function_to_add), $priority, $accepted_args );
	}

	public function addFilter( $tag, $function_to_add, $priority = 30, $accepted_args = 1 ) {
		add_action( $tag, array( &$this, $function_to_add), $priority, $accepted_args );
	}
}
