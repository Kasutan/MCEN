<?php 
/*Plugin Name: Article à la une	
Description: Cette extension permet de gérer l'article à la une. Nécessite que l'extension Meta Box soit installée et activée.
Version: 1.0
License: GPLv2
*/

//Gestion de l'article à la une - A déplacer dans un plugin 
    add_filter( 'rwmb_meta_boxes', 'mcen_meta_boxes' );
    function mcen_meta_boxes( $meta_boxes ) {
        $meta_boxes[] = array(
            'title'      => __( 'Article à la une', 'mcen_s' ),
            'post_types' => 'post',
            'fields'     => array(
                array(
                    'id'      => 'a_la_une',
                    'name'    => __( 'Mettre cet article à la une ?', 'mcen_s' ),
                    'type'    => 'radio',
                    'options' => array(
                        '1' => __( 'Oui', 'mcen_s' ),
                        '0' => __( 'Non', 'mcen_s' ),
                    ),
                )
               
            )
        );
        return $meta_boxes;
    }

function un_seul_article_a_la_une( $post_id) {
	//Vérifier si l'article qu'on vient d'enregistrer doit être à la une
	if (rwmb_meta('a_la_une', $empty_array, $post_id)=='1')
	{	//Récupérer les autres articles qui sont marqués à la une
		$args = array(
				'post_type' => 'post',
				'post__not_in'=> array(
					$post_id
				),
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
				while($query->have_posts()) :
					$query->the_post();
					$id=get_the_ID();
					$empty_array=array();
					apply_filters('rwmb_meta','0','a_la_une',$empty_array, $id);
					update_post_meta($id, 'a_la_une', '0');
				endwhile;
			endif;
			wp_reset_postdata();
	}
}	

add_action('save_post','un_seul_article_a_la_une');

//Ajouter une colonne dans l'admin 
function affiche_si_article_a_la_une( $column, $post_id ) {
    if ($column == 'colonne_a_la_une'){
		$est_a_la_une = rwmb_meta( 'a_la_une', array(), $post_id);
		if ($est_a_la_une=='1') {
			echo 'Oui';
		} else { 
			echo 'Non';
		}
    }
}
add_action( 'manage_posts_custom_column' , 'affiche_si_article_a_la_une', 10, 2 );


function ajoute_colonne_a_la_une($columns) {
    return array_merge( $columns, 
              array('colonne_a_la_une' => 'A la une') );
}
add_filter('manage_posts_columns' , 'ajoute_colonne_a_la_une');
