<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
	<?php

		$sidebar = halim_custom_sidebar();
		if ( $sidebar != 'halim_nosidebar' ) {
			if( is_active_sidebar( $sidebar ) ) {
			    dynamic_sidebar( $sidebar );
			} else {
				_e('This is widget area. Go to Appearance -> Widgets to add some widgets.', 'halimthemes');
			}
		}
	?>
</aside>