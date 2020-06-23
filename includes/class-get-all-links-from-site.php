<?php

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

class GetAllLinksFromSite {

	public function get_all_links() {

		$posts = new WP_Query('post_type=any&posts_per_page=-1&post_status=publish');
		$posts = $posts->posts;

		foreach ($posts as $post) {
			switch ($post->post_type) {
			case 'revision':
			case 'nav_menu_item':
				break;
			case 'page':
				$permalink = get_page_link($post->ID);
				break;
			case 'post':
				$permalink = get_permalink($post->ID);
				break;
			case 'attachment':
				$permalink = get_attachment_link($post->ID);
				break;
			default:
				$permalink = get_post_permalink($post->ID);
				break;
			}

			$new_ar[] = $permalink;
		}

		return $new_ar;
	}

}