<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package mcen_s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title">Actualités</h1>
	</header>
	<!-- .entry-header -->
	
		
	<div class="container"> 
		<?php if (rwmb_meta( 'a_la_une')=='1') {
			echo "<h2>à la une</h2>";
		} ?>
		<div class="entry-content flex-column single 1-1">
			<div>
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail('single');}?>
			</div>
			<div class="texte">
				<?php 	the_title( '<h3 class="entry-title">', '</h3>' ); ?>
				<p class="entry-meta">
					Posté par <strong><?php the_author(); ?></strong> | Le <?php the_time("j F Y"); ?>
				</p>
				<p>
				<?php the_content();?>
				</p>
			</div>

		</div><!-- .entry-content -->
	</div>

	
</article><!-- #post-## -->
