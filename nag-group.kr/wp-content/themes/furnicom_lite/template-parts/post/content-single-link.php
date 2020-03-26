<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Furnicom_lite
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php furnicom_lite_ads_post_before_content() ?>

	<div class="post__left-col"><?php
		get_template_part( 'template-parts/post/post-meta/content-meta-date' );
		furnicom_lite_share_buttons( 'single' );
	?></div><!-- .post__left-col -->

	<div class="post__right-col">
		<header class="entry-header"><?php
			get_template_part( 'template-parts/post/post-components/post-title' );
			get_template_part( 'template-parts/post/post-meta/content-meta-author' );
			get_template_part( 'template-parts/post/post-meta/content-meta-categories' );

			do_action( 'cherry_trend_posts_display_views' );
		?></header><!-- .entry-header -->

		<div class="post-featured-content">
			<?php do_action( 'cherry_post_format_link', array(
				'render' => true,
			) ); ?>
		</div><!-- .post-featured-content -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links__title">' . esc_html__( 'Pages:', 'furnicom_lite' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span class="page-links__item">',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'furnicom_lite' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
			?>
		</div><!-- .entry-content -->
		<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
			<a href="javascript:void addChannel()">
			  <img src="https://developers.kakao.com/assets/img/about/logos/channel/friendadd_large_yellow_rect.png"/></a>
				<script type='text/javascript'>
				  //<![CDATA[
				    // 사용할 앱의 JavaScript 키를 설정해 주세요.
				    Kakao.init('73844eff443afc1b64a3643abd0ac567');
				    		    function addChannel() {
				      Kakao.Channel.addChannel({
				        channelPublicId: '_xcLqmC' // 채널 홈 URL에 명시된 id로 설정합니다.
				      });
				    }
				  //]]>
				</script>
				<footer class="entry-footer">
			<div class="entry-meta-container">
				<div class="entry-meta entry-meta--left"><?php
					get_template_part( 'template-parts/post/post-meta/content-meta-tags' );
				?></div>

			</div>
			<?php do_action( 'cherry_trend_posts_display_rating' ); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .post__right-col -->

</article><!-- #post-## -->
