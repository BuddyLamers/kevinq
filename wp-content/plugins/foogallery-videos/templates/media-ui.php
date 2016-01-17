<script type="text/html" id="video-search-youtube-tmpl" xmlns="http://www.w3.org/1999/html">

<div class="foovideo-browser">

	<div class="foovideo-toolbar foovideo-youtube">

		<input type="search" placeholder="<?php _e('Search term, URL, Playlist ID or video ID','foo-video'); ?>" class="foovideo-searchbox search" data-type="youtube"><span class="spinner video-search-spinner" style="float: none; display: inline-block; margin-left: 12px; padding: 2px;"></span>

	</div>

	<div class="foovideo-results foovideo-youtube" data-loading="<?php echo esc_attr('Importing Video(s)', 'foo-video'); ?>">

		<div style="padding:12px;">

			<p> <?php _e('There are three ways to add videos from YouTube.', 'foo-video' ); ?></p>

			<ol>

				<li><?php _e('Search using any keywords, highlight one or more videos, then choose Add Media', 'foo-video' ); ?></li>

				<li><?php _e('Paste an individual video ID, or URL and hit Enter', 'foo-video' ); ?></li>

				<li><?php _e('Paste a Playlist URL to import selected or all videos included in the Playlist', 'foo-video' ); ?></li>

			</ol>

		</div>

	</div>

</div>

</script>

<script type="text/html" id="video-search-vimeo-tmpl">

<div class="foovideo-browser">

	<div class="foovideo-toolbar foovideo-vimeo">

		<input type="search" placeholder="<?php _e('Video, Album or User URL','foo-video'); ?>" class="foovideo-searchbox search" data-type="vimeo"><span class="spinner video-search-spinner" style="float: none; display: inline-block; margin-left: 12px; padding: 2px;"></span>

	</div>

	<div class="foovideo-results foovideo-vimeo" data-loading="<?php echo esc_attr('Importing Video(s)', 'foo-video'); ?>">

		<div style="padding:12px;">

			<p> <?php _e('There are three ways to add videos from Vimeo.', 'foo-video' ); ?></p>



			<em>

				<a href="https://vimeo.com/search" title="<?php _e( 'Search Viemo', 'foo-video' ); ?>" target="_blank">

					<?php _e( 'Click Here To Search For Your Video On Vimeo', 'foo-video' ); ?>

				</a>

			</em>

			<ol>

				<li><?php _e('Paste an individual video URL and hit Enter.', 'foo-video' ); ?></li>

				<li><?php _e('Paste an Album URL to import selected or all videos included in the Playlist.', 'foo-video' ); ?></li>

				<li><?php _e('Paste a User\'s URL to import selected or all videos uploaded by the user.', 'foo-video' ); ?></li>

			</ol>

		</div>

	</div>

</div>

</script>

