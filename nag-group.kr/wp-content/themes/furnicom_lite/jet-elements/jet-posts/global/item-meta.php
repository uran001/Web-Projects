<?php
/**
 * Loop item meta
 */

if ('yes' !== $this->get_attr('show_meta')) {
	return;
}

echo '<div class="entry-meta">';

if ('yes' !== $this->get_attr('show_image')) {
	jet_elements()->utility()->meta_data->get_date(array(
		'class' => 'post__date-link',
		'html' => '<span class="post__date">%1$s<a href="%2$s" %3$s %4$s ><time datetime="%5$s" title="%5$s">%6$s%7$s</time></a></span>',
		'echo' => true,
	));
}

if ('yes' == $this->get_attr('show_meta')) {
	jet_elements()->utility()->meta_data->get_author( array(
		'visible' => $this->get_attr( 'show_author' ),
		'class'   => 'posted-by__author',
		'prefix'  => esc_html__( 'Posted by ', 'jet-elements' ),
		'html'    => '<span class="posted-by post-meta__item">%1$s<a href="%2$s" %3$s %4$s rel="author">%5$s%6$s</a></span>',
		'echo'    => true,
	));

	jet_elements()->utility()->meta_data->get_date( array(
		'visible' => $this->get_attr( 'show_date' ),
		'class'   => 'post__date-link',
		'icon'    => '',
		'html'    => '<span class="post__date post-meta__item">%1$s<a href="%2$s" %3$s %4$s ><time datetime="%5$s" title="%5$s">%6$s%7$s</time></a></span>',
		'echo'    => true,
	));




}

echo '</div>';
