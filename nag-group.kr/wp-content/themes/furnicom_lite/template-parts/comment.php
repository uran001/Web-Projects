<?php
/**
 * The template for displaying comments.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 *
 * @package Furnicom_lite
 */
?>
<div class="comment-author vcard">
	<?php echo furnicom_lite_comment_author_avatar(); ?>
</div>
<div class="comment-content-wrap">
	<footer class="comment-meta">
		<div class="comment-metadata">
			<?php echo furnicom_lite_get_comment_author_link(); ?>
			<?php echo furnicom_lite_get_comment_date( array(
				'format' => 'M d, Y',
			) ); ?>
		</div>
	</footer>
	<div class="comment-content">
		<?php echo furnicom_lite_get_comment_text(); ?>
	</div>
	<div class="reply">
		<?php echo furnicom_lite_get_comment_reply_link( array(
			'reply_text' => esc_html__( 'Reply', 'furnicom_lite' ),
		) ); ?>
	</div>
</div>
