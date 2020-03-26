<?php
/**
 * Set item
 *
 * @package templates/frontend/grid/items
 */

$folder     = $data->gallery_folder;
$data_attrs = sprintf(
	'data-image-width="%1$s" data-image-height="%2$s"',
	isset( $data->cover[1] ) ? $data->cover[1] : 445,
	isset( $data->cover[2] ) ? $data->cover[2] : 350
);

$img_count    = $data->img_count['images'];
$albums_count = $data->img_count['albums'];

?>

<div class="tm_pg_gallery-item <?php echo apply_filters( 'tm-pg-gallery-item-class', '' ) ?>" data-id="<?php echo $data->ID ?>" data-type="set" <?php echo $data_attrs ?>>
	<div class="tm_pg_gallery-item-wrapper">
		<a href="<?php do_action( 'tm-pg-the_post_link', $data ) ?>" class="tm_pg_gallery-item_link" data-effect="fadeIn">
			<?php if ( $data->display['title'][ $folder ] || $data->display['counter'][ $folder ] || $data->display['description'][ $folder ] ): ?>
				<div class="tm_pg_gallery-item_meta">
					<div class="tm_pg_gallery-item_icon-wrapper">
						<?php $show_default_icon = true; ?>
						<?php if ( $data->display['icon'][ $folder ] ): ?>
							<i class="tm_pg_gallery-item_icon nc-icon-outline files_folder-gallery"></i>
							<?php $show_default_icon = false; ?>
						<?php endif; ?>
					</div>
					<?php if ( $data->display['title'][ $folder ] ): ?>
						<h3 class="tm_pg_gallery-item_title"><?php echo $data->post_title ?></h3>
						<?php $show_default_icon = false; ?>
					<?php endif; ?>
					<?php if ( $data->display['counter'][ $folder ] ): ?>
						<p class="tm_pg_gallery-item_counter"><?php
							printf(
								esc_html( _nx( '1 photo', '%1$s photos', $img_count, 'set images', 'furnicom_lite' ) ),
								number_format_i18n( $img_count )
							);
							if ( 0 < $data->img_count['albums'] ) {
								?>, <?php
								printf(
									esc_html( _nx( '1 album', '%1$s albums', $albums_count, 'set albums', 'furnicom_lite' ) ),
									number_format_i18n( $albums_count )
								);
							}
							?></p>
						<?php $show_default_icon = false; ?>
					<?php endif; ?>
					<?php if ( $data->display['description'][ $folder ] ): ?>
						<p class="tm_pg_gallery-item_description"><?php echo wp_trim_words( $data->post_content, intval( $data->display['description_trim'][ $folder ] ) ); ?></p>
						<?php $show_default_icon = false; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<img src="<?php echo ! empty( $data->cover[0] ) ? $data->cover[0] : TM_PG_IMG_URL . 'no-image.png' ?>" alt="">
			<?php if ( $data->display['labels'][ $folder ] ): ?>
				<div class="tm_pg_gallery-item_label"><?php echo $data->display['set_label'][ $folder ] ?></div>
			<?php endif; ?>
		</a>
	</div>
</div>
