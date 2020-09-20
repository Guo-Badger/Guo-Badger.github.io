<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( 1 === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'uw-theme' ), get_the_title() );
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s thought on &ldquo;%2$s&rdquo;',
							'%1$s thoughts on &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'uw-theme'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 42,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'uw-theme' ); ?></p>
	<?php endif; ?>

	<?php
		$fields =  array(

		  'author' =>
		    '<p class="comment-form-author"><label for="author">' . __( 'Name', 'uw-theme' ) . '</label> <span aria-hidden="true" class="required">*</span>' .
		    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		    '" size="30" aria-required="true" /></p>',

		  'email' =>
		    '<p class="comment-form-email"><label for="email">' . __( 'Email', 'uw-theme' ) . '</label>  <span aria-hidden="true" class="required">*</span>' .
		    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		    '" size="30" aria-required="true" /></p>',

		  'url' =>
		    '<p class="comment-form-url"><label for="url">' . __( 'Website', 'uw-theme' ) . '</label>' .
		    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		    '" size="30" /></p>',
		);

		comment_form( array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
			'fields' => $fields
		) );
	?>

</div><!-- .comments-area -->
