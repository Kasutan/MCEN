<?php
/**
 * Template part for displaying page content in page-actualites.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package mcen_s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if(!is_front_page()){ the_title( '<h1 class="entry-title">', '</h1>' );} ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="container">
			<?php
			//Recherche de l'article à la une
				$args = array(
					'post_type' => 'post',
					'posts_per_page'=> 1,
					'meta_query' => array(
						array(
							'key'     => 'a_la_une',
							'value'   => '1',
							'compare' => '=',
						),
					)
				);
				$query = new WP_Query($args);

				if($query->have_posts()):
					_e("<h2>à la une</h2>",'mcen_s');
					while($query->have_posts()) :
						$query->the_post();
						?>
						<div class="flex-column 2-1 article">
							<div>
								<?php if ( has_post_thumbnail() ) { the_post_thumbnail(array(594,300));}?>
							</div>
							<div class="texte">
								<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
								<p class="entry-meta">
									Posté par <strong><?php the_author(); ?></strong> | Le <?php the_time("j F Y"); ?>
								</p> 
								<?php the_excerpt(); ?>
								<p>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="lien-fleche"><?php _e('Lire la suite','mcen_s');?></a>
								</p>
							</div>
						</div>
						<?
					endwhile;
				endif;
				wp_reset_postdata();

			?>

			<h2><?php _e('Nos articles','mcen_s')?></h2>
			<?php
				//Les autres articles, affichés par le plugin Ajax Load More
				the_content();
			?>
		</div>
	</div><!-- .entry-content <--></-->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'mcen_s' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
