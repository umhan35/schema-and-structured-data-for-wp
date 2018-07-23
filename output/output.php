<?php

if (! defined('ABSPATH') ) exit;

add_action('wp_head', 'kb_schema_output');
function kb_schema_output() {
	global $sd_data;
	if( (!ampforwp_sd_non_amp() && $sd_data['sd-for-ampforwp']!=1) || (ampforwp_sd_non_amp() && $sd_data['sd-for-wordpress']!=1) ) {
		return ;
	}
	// social profile
	$sd_social_profile = array();

	$sd_facebook = array();
	if(isset($sd_data['sd_facebook']) && !empty($sd_data['sd_facebook'])){
		$sd_facebook[] = $sd_data['sd_facebook'];
		$sd_social_profile[] = $sd_facebook;
	}

	$sd_twitter = array();
	if(isset($sd_data['sd_twitter']) && !empty($sd_data['sd_twitter'])){
		$sd_twitter[] = $sd_data['sd_twitter'];
		$sd_social_profile[] = $sd_twitter;
	}

	$sd_google_plus = array();
	if(isset($sd_data['sd_google_plus']) && !empty($sd_data['sd_google_plus'])){
		$sd_google_plus[] = $sd_data['sd_google_plus'];	
		$sd_social_profile[] = $sd_google_plus;
	}

	$sd_instagram = array();
	if(isset($sd_data['sd_instagram']) && !empty($sd_data['sd_instagram'])){
		$sd_instagram[] = $sd_data['sd_instagram'];
		$sd_social_profile[] = $sd_instagram;
		}

	$sd_youtube = array();
	if(isset($sd_data['sd_youtube']) && !empty($sd_data['sd_youtube'])){
		$sd_youtube[] = $sd_data['sd_youtube'];
		$sd_social_profile[] = $sd_youtube;
	}

	$sd_linkedin = array();
	if(isset($sd_data['sd_linkedin']) && !empty($sd_data['sd_linkedin'])){
		$sd_linkedin[] = $sd_data['sd_linkedin'];
		$sd_social_profile[] = $sd_linkedin;
	}

	$sd_pinterest = array();
	if(isset($sd_data['sd_pinterest']) && !empty($sd_data['sd_pinterest'])){
		$sd_pinterest[] = $sd_data['sd_pinterest'];
		$sd_social_profile[] = $sd_pinterest;
	}

	$sd_soundcloud = array();
	if(isset($sd_data['sd_soundcloud']) && !empty($sd_data['sd_soundcloud'])){
		$sd_soundcloud[] = $sd_data['sd_soundcloud'];
		$sd_social_profile[] = $sd_soundcloud;
		}

	$sd_tumblr = array();
	if(isset($sd_data['sd_tumblr']) && !empty($sd_data['sd_tumblr'])){
		$sd_tumblr[] = $sd_data['sd_tumblr'];
		$sd_social_profile[] = $sd_tumblr;
		}

	$platform = array();
	foreach ($sd_social_profile as $key => $value) {
		$platform[] = $value; 
	}
	
	// Organization Schema 


	if ( $sd_data['sd_kb_type']  ==  'Organization' ) {
		$logo = $sd_data['sd_logo']['url'];
		$contact_1 = $sd_data['sd_contact_type'];
		$telephone_1 = $sd_data['sd_kb_telephone'];
		$height = $sd_data['sd_logo']['height'];
		$width = $sd_data['sd_logo']['width'];

		if( '' ==  $logo && empty($logo) && isset($sd_data['sd_default_image'])){
			$logo = $sd_data['sd_default_image']['url'];
		}
		
		if( '' ==  $height && empty($height) && isset($sd_data['sd_default_image_height'])){
			$height = $sd_data['sd_default_image_height'];
		}
		
		if( '' ==  $width && empty($width) && isset($sd_data['sd_default_image_width'])){
			$width = $sd_data['sd_default_image_width'];
		}

		if( '' ==  $contact_1 && empty($contact_1) && isset($sd_data['sd_contact_type'])){
			$contact_1 = $sd_data['sd_contact_type'];
		}

		if( '' ==  $telephone_1 && empty($telephone_1) && isset($sd_data['sd_kb_telephone'])){
			$telephone_1 = $sd_data['sd_kb_telephone'];
		}

		// Contact Information
	 	$contact_info = array();
	 	$contact_info = array(
	 		'contactPoint' => array(
		      	'@type'    => 'ContactPoint',
		      	'contactType'  => $contact_1,
		      	'telephone'    => $telephone_1,
			)
 		);

		$input = array(
		'@context'		=>'http://schema.org',
		'@type'			=> $sd_data['sd_kb_type'],
		'name'			=> $sd_data['sd_name'],
		'url'			=> $sd_data['sd_url'],
		'sameAs'		=> $platform,
		'logo' 			=> array(
					'@type'		=> 'ImageObject',
					'url'		=> $logo,
					'width'		=> $width,
					'height'	=> $height,
					), 
		'alternateName'	=> $sd_data['sd_alt_name']
		);

		if ( isset($sd_data['sd_kb_contact_1'] ) && $sd_data['sd_kb_contact_1'] ) {
			$input = array_merge($input, $contact_info);
		}

}

	
		
		
		// Person

	if ( $sd_data['sd_kb_type']  ==  'Person' ) {
		$image = $sd_data['sd-person-image']['url'];
		$height = $sd_data['sd-person-image']['height'];
		$width = $sd_data['sd-person-image']['width'];
		if( '' ==  $image && empty($image) && isset($sd_data['sd_default_image'])){
			$image = $sd_data['sd_default_image']['url'];
		}
		
		if( '' ==  $height && empty($height) && isset($sd_data['sd_default_image_height'])){
			$height = $sd_data['sd_default_image_height'];
		}
		
		if( '' ==  $width && empty($width) && isset($sd_data['sd_default_image_width'])){
			$width = $sd_data['sd_default_image_width'];
		}

		echo $input;
		$input = array(
			'@context'		=>'http://schema.org',
			'@type'			=> $sd_data['sd_kb_type'],
			'name'			=> $sd_data['sd-person-name'],
			'url'			=> $sd_data['sd-person-url'],
			'Image' 			=> array(
					'@type'		=> 'ImageObject',
					'url'		=> $image,
					'width'		=> $width,
					'height'	=> $height,
					),
			'telephone'		=> $sd_data['sd-person-phone-number'],

			/*'sameAs'		=> array(
				'https://twitter.com/verticalmeasure',
				'https://www.facebook.com/verticalmeasures'
			)*/
			);
	}

	echo structured_data_generator($input);	 
    
}

function sd_is_blog() {
    return ( is_author() || is_category() || is_tag() || is_date() || is_home() || is_single() ) && 'post' == get_post_type();
}



add_action('wp_head', 'schema_output');
function schema_output() {
	global $sd_data;

	$schemaConditionals = ampforwp_get_all_schema_posts();
	if(!$schemaConditionals){
		return ;
	}
	if( (!ampforwp_sd_non_amp() && $sd_data['sd-for-ampforwp']!=1) || (ampforwp_sd_non_amp() && $sd_data['sd-for-wordpress']!=1) ) {
		return ;
	}
	$schema_options = $schemaConditionals['schema_options'];
	$schema_type = $schemaConditionals['schema_type'];
	$logo = $sd_data['sd_logo']['url'];
		if( '' == $logo && empty($logo) && isset($sd_data['sd_default_image'])){
			$logo = $sd_data['sd_default_image']['url'];
		}
		$height = $sd_data['sd_logo']['height'];
		if( '' == $height && empty($height) && isset($sd_data['sd_default_image_height'])){
			$height = $sd_data['sd_default_image_height'];
		}
		$width = $sd_data['sd_logo']['width'];
		if( '' == $width && empty($width) && isset($sd_data['sd_default_image_width'])){
			$width = $sd_data['sd_default_image_width'];
		}
	if(is_singular()){
		// Generate author id
	   		$author_id = get_the_author_meta('ID');

		// Blogposting Schema 
			$image_id 		= get_post_thumbnail_id();
			$image_details 	= wp_get_attachment_image_src($image_id, 'full');
			if(isset($image_details['url'])){
				$image_url		= $image_details['url'];
			}
			$author_details	= get_avatar_data($author_id);
			$date 			= get_the_date();
			$modified_date 	= get_the_modified_date();
			$aurthor_name 	= get_the_author();
			
			if(is_page()){
				$schema_type = $schema_type; //$sd_data['sd_page_type'];
			}
			if(is_single()){
				$schema_type = $schema_type; //$sd_data['sd_post_type'];
			}
			if(is_front_page()){
				$schema_type = $schema_type; // $sd_data['sd_page_type'];
			}
			$input1 = array(
			'@context'			=> 'http://schema.org',
			'@type'				=> $schema_type ,

			'mainEntityOfPage'	=> get_permalink(),
			'headline'			=> get_the_title(),
			'description'		=> get_the_excerpt(),
			'name'				=> get_the_title(),
			'url'				=> get_permalink(),
			'datePublished' 	=> $date,
			'dateModified'		=> $modified_date,
			'author'			=> array(
					'@type' 	=> 'Person',
					'name'		=> $aurthor_name, ),
			'Publisher'			=> array(
				'@type'			=> 'Organization',
				'logo' 			=> array(
					'@type'		=> 'ImageObject',
					'url'		=> $logo,
					'width'		=> $width,
					'height'	=> $height,
					),
				'name'			=> $sd_data['sd_name'],
				),
			);
			// For WebPage
			if( 'WebPage' === $schema_type){
				if(empty($image_details[0]) || $image_details[0] === NULL ){
					$image_details[0] = $logo;
				}

				$input1 = array(
				'@context'			=> 'http://schema.org',
				'@type'				=> $schema_type ,
				'name'				=> get_the_title(),
				'url'				=> get_permalink(),
				'description'		=> get_the_excerpt(),
				'mainEntity'		=> array(
						'@type'				=> 'Article',
						'mainEntityOfPage'	=> get_permalink(),
						'image'				=> $image_details[0],
						'headline'			=> get_the_title(),
						'description'		=> get_the_excerpt(),
						'datePublished' 	=> $date,
						'dateModified'		=> $modified_date,
						'author'			=> array(
								'@type' 	=> 'Person',
								'name'		=> $aurthor_name, ),
						'Publisher'			=> array(
							'@type'			=> 'Organization',
							'logo' 			=> array(
								'@type'		=> 'ImageObject',
								'url'		=> $logo,
								'width'		=> $width,
								'height'	=> $height,
								),
							'name'			=> $sd_data['sd_name'],
						),
					),
					
				
				);
				if(isset($sd_data['breadcrumb_schema']) && $sd_data['breadcrumb_schema'] == 1){
					$input1['BreadcrumbList'] = schema_breadcrumb_output($sd_data);
				}
			}

		// For Article
		
			if( 'Article' === $schema_type ){
				$input1 = array(
					'@context'			=> 'http://schema.org',
					'@type'				=> 'Article',
					'mainEntityOfPage'	=> get_permalink(),
					'image'				=> $image_details[0],
					'headline'			=> get_the_title(),
					'description'		=> get_the_excerpt(),
					'datePublished' 	=> $date,
					'dateModified'		=> $modified_date,
					'author'			=> array(
							'@type' 	=> 'Person',
							'name'		=> $aurthor_name, ),
					'Publisher'			=> array(
						'@type'			=> 'Organization',
						'logo' 			=> array(
							'@type'		=> 'ImageObject',
							'url'		=> $sd_data['sd_logo']['url'],
							'width'		=> $sd_data['sd_logo']['width'],
							'height'	=> $sd_data['sd_logo']['height'],
							),
						'name'			=> $sd_data['sd_name'],
					),
				);
			}

		// Recipe
			if( 'Recipe' === $schema_type){
				if(empty($image_details[0]) || $image_details[0] === NULL ){
					$image_details[0] = $sd_data['sd_logo']['url'];
				}
				$input1 = array(
				'@context'			=> 'http://schema.org',
				'@type'				=> $schema_type ,
				'url'				=> get_permalink(),
				'headline'			=> get_the_title(),
				'datePublished' 	=> $date,
				'dateModified'		=> $modified_date,
				'description'		=> get_the_excerpt(),
				'mainEntity'		=> array(
						'@type'				=> 'WebPage',
						'@id'				=> get_permalink(),
						'author'			=> array(
								'@type' 	=> 'Person',
								'name'		=> $aurthor_name,
								'Image'		=> array(
									'@type'			=> 'ImageObject',
									'url'			=> $author_details['url'],
									'height'		=> $author_details['height'],
									'width'			=> $author_details['width']
								),
							),
						'Publisher'			=> array(
							'@type'			=> 'Organization',
							'logo' 			=> array(
								'@type'		=> 'ImageObject',
								'url'		=> $sd_data['sd_logo']['url'],
								'width'		=> $sd_data['sd_logo']['width'],
								'height'	=> $sd_data['sd_logo']['height'],
								),
							'name'			=> $sd_data['sd_name'],
						),
					),
					
				
				);
			}

			// Product
			
			if(  'Product' === $schema_type){
				if(empty($image_details[0]) || $image_details[0] === NULL ){
					$image_details[0] = $logo;
				}
				$input1 = array(
				'@context'			=> 'http://schema.org',
				'@type'				=> $schema_type ,
				'url'				=> get_permalink(),
				'name'			=> get_the_title(),
				'description'		=> get_the_excerpt(),
				'mainEntity'		=> array(
						'@type'				=> 'WebPage',
						'@id'				=> get_permalink(),
					),
					
				
				);
			}

			// VideoObject
			if( 'VideoObject' === $schema_type){
				if(empty($image_details[0]) || $image_details[0] === NULL ){
					$image_details[0] = $sd_data['sd_logo']['url'];
				}
				
				if( 'NewsArticle' === $schema_type ){  
						$input1 = array(
					'@context'			=> 'http://schema.org',
					'@type'				=> $schema_type ,
					'@type'				=> $schema_type,
					'mainEntityOfPage'	=> get_permalink(),
					'url'				=> get_permalink(),
					'headline'			=> get_the_title(),
					'datePublished' 	=> $date,
					'dateModified'		=> $modified_date,
					'description'		=> get_the_excerpt(),
					'name'				=> get_the_title(), 
					// 'uploadDate'		=> $date,
					'thumbnailUrl'		=> $image_details[0],
					'mainEntity'		=> array(
								'@type'				=> 'WebPage',
								'@id'				=> get_permalink(),
						), 
					'author'			=> array(
							'@type' 			=> 'Person',
							'name'				=> $aurthor_name,
							'Image'				=> array(
							'@type'				=> 'ImageObject',
							'url'				=> $author_details['url'],
							'height'			=> $author_details['height'],
							'width'				=> $author_details['width']
										),
							),
					'Publisher'			=> array(
							'@type'				=> 'Organization',
							'logo' 				=> array(
							'@type'				=> 'ImageObject',
							'url'				=> $sd_data['sd_logo']['url'],
							'width'				=> $sd_data['sd_logo']['width'],
							'height'			=> $sd_data['sd_logo']['height'],
										),
							'name'				=> $sd_data['sd_name'],
							),
					);
				}
				else {
					
						$input1 = array(
						'@context'			=> 'http://schema.org',
						'@type'				=> $schema_type,
						'url'				=> get_permalink(),
						'headline'			=> get_the_title(),
						'datePublished' 	=> $date,
						'dateModified'		=> $modified_date,
						'description'		=> get_the_excerpt(),
						'name'				=> get_the_title(),
						'uploadDate'		=> $date,
						'thumbnailUrl'		=> $image_details[0],
						'mainEntity'		=> array(
								'@type'				=> 'WebPage',
								'@id'				=> get_permalink(),
								), 
						'author'			=> array(
								'@type' 			=> 'Person',
								'name'				=> $aurthor_name,
								'Image'				=> array(
								'@type'				=> 'ImageObject',
								'url'				=> $author_details['url'],
								'height'			=> $author_details['height'],
								'width'				=> $author_details['width']
								),
							),
						'Publisher'			=> array(
								'@type'				=> 'Organization',
								'logo' 				=> array(
								'@type'				=> 'ImageObject',
								'url'				=> $sd_data['sd_logo']['url'],
								'width'				=> $sd_data['sd_logo']['width'],
								'height'			=> $sd_data['sd_logo']['height'],
										),
								'name'			=> $sd_data['sd_name'],
							),
						);
					}
				}

		//Check for Featured Image
			if( is_array($image_details) ){
				if(isset($image_details[1]) ){
						$width = $image_details[1];	
					}
					if(isset($image_details[2])){
						$height = $image_details[2];
					}
			$input2  = array(
				'image'				=>array(
						'@type'		=>'ImageObject',
						'url'		=>$image_details[0],
						'width'		=>$width,
						'height'	=>$height,),
				);
			$input = array_merge($input1,$input2);
		}
			else{			
				$input2  = array(
				'image'				=>array(
						'@type'		=>'ImageObject',
						'url'		=> $sd_data['sd_logo']['url'],
					'width'		=> $sd_data['sd_logo']['width'],
					'height'	=> $sd_data['sd_logo']['height'],),
				);
				$input = array_merge($input1,$input2);
		}
		if($schema_options['notAccessibleForFree']==1){
			add_filter( 'amp_post_template_data', 'ampforwp_structure_data_access_scripts');
			/*add_action( 'amp_post_template_head', 'ampforwp_structure_data_access_scripts_json');*/
			$paywall_class_name = $schema_options['paywall_class_name'];
			$isAccessibleForFree = isset($schema_options['isAccessibleForFree'])? $schema_options['isAccessibleForFree']: False;
			if($paywall_class_name!=""){
				if(strpos($paywall_class_name, ".")==-1){
					$paywall_class_name = ".".$paywall_class_name;
				}
				$paywallData = array("isAccessibleForFree"=> $isAccessibleForFree,
									  "hasPart"=>array(
										    "@type"=> "WebPageElement",
										    "isAccessibleForFree"=> $isAccessibleForFree,
										    "cssSelector" => $paywall_class_name
										    )
										);
				$input = array_merge($input,$paywallData);
			}
		}
		echo structured_data_generator($input);	 
	}

}

function ampforwp_structure_data_access_scripts($data){
	if ( empty( $data['amp_component_scripts']['amp-access'] ) ) {
		$data['amp_component_scripts']['amp-access'] = 'https://cdn.ampproject.org/v0/amp-access-0.1.js';
	}
	if ( empty( $data['amp_component_scripts']['amp-analytics'] ) ) {
		$data['amp_component_scripts']['amp-analytics'] = "https://cdn.ampproject.org/v0/amp-analytics-0.1.js";
	}
	if ( empty( $data['amp_component_scripts']['amp-mustache'] ) ) {
		$data['amp_component_scripts']['amp-mustache'] = "https://cdn.ampproject.org/v0/amp-mustache-0.1.js";
	}
	return $data;
}


//We have to work on this
// Output is somewhat different from required output


//Breadcrumbs
function list_items_generator(){
		global $sd_data;
		$bc_titles = array();
		$bc_links = array();
	if(isset($sd_data['titles'])){		
			$bc_titles = $sd_data['titles'];
		}
		if(isset($sd_data['links'])){
			$bc_links = $sd_data['links'];
		}
	$post_id = get_option('page_for_posts');
	$post = get_post($post_id);
	$slug = $post->post_name;
	$blog_posts_page_slug = '/'.$slug;
	$site_name = get_bloginfo('blogname');
$j=1;
$i = 0;
$breadcrumbslist = array();
if(is_single()){
	if(isset($bc_titles)){
	for($i=0;$i<sizeof($bc_titles);$i++){
		$breadcrumbslist[] = array(
								'@type'			=> 'ListItem',
								'position'		=> $j,
								'item'			=> array(
									'@id'		=>	$bc_links[$i],
									'name'		=> $bc_titles[$i],
									),
							);
		$j++;
		}}
		$breadcrumbslist[] = array(
								'@type' 		=>'ListItem',
								'position'		=> $j,
								'item'			=> array(
									'@id'		=> get_permalink(),
									'name'		=> get_the_title(),

								),
							);
}
if(is_page()){

	for($i=0;$i<sizeof($bc_titles);$i++){
		$breadcrumbslist[] = array(
								'@type'			=> 'ListItem',
								'position'		=> $j,
								'item'			=> array(
									'@id'		=>	$bc_links[$i],
									'name'		=> $bc_titles[$i],
									),
							);
		$j++;
		}

}
if(is_archive()){

	for($i=0;$i<sizeof($bc_titles);$i++){
		$breadcrumbslist[] = array(
								'@type'			=> 'ListItem',
								'position'		=> $j,
								'item'			=> array(
									'@id'		=>	$bc_links[$i],
									'name'		=> $bc_titles[$i],
									),
							);
		$j++;
		}

}

return $breadcrumbslist;
}
add_action( 'wp_head', 'schema_breadcrumb_output');
function schema_breadcrumb_output($sd_data){
	global $sd_data;
	if( (!ampforwp_sd_non_amp() && $sd_data['sd-for-ampforwp']!=1) || (ampforwp_sd_non_amp() && $sd_data['sd-for-wordpress']!=1) ) {
		return ;
	}
	if(isset($sd_data['breadcrumb_schema']) && $sd_data['breadcrumb_schema'] == 1){
		if(isset($sd_data['titles'])){		
			$bc_titles = $sd_data['titles'];
		}
		if(isset($sd_data['links'])){
			$bc_links = $sd_data['links'];
		}
		$post_id = get_option('page_for_posts');
		$post = get_post($post_id);
		$slug = $post->post_name;
		$blog_posts_page_slug = '/'.$slug;
		$site_name = get_bloginfo('blogname');
	$j=1;
		
		$input = array(
					'@context'			=> 'http://schema.org',
					'@type'				=> 'BreadcrumbList' ,
					'itemListElement'	=>list_items_generator(),
			);
		if ( !is_front_page() ) {
			echo structured_data_generator($input);
		 }
	}
}

//Output of schema_breadcrumb_output2

/*
"@context":"http:\/\/schema.org",
"@type":"BreadcrumbList",
"itemListElement":
[
	{
	"@type":"ListItem",
	"position":1,
	"item":
		{
		"@id":"http:\/\/localhost\/wp",
		"name":"Homepage"
		}
	},
	{
	"@type":"ListItem",
	"position":2,
	"item":
		{
		"@id":"http:\/\/localhost\/wp\/call-example\/",
		"name":"Call example"
		}
	}
]
*/



/*Breadcrumbs output 

@context":"http:\/\/schema.org",
"@type":"BreadcrumbList",
"itemListElement":
 [
  {
	"@type":"ListItem",
	"position":1,
	"item":
   {
	"@id":"https:\/\/example.com\/dresses",
	"name":"Dresses"
   }
  },
  {
	"@type":"ListItem",
	"position":2,
	"item":
   {
	"@id":"https:\/\/example.com\/dresses\/real",
	"name":"Real Dresses"
   }
  }
]

*/

/*"@context": "http://schema.org",
 "@type": "BreadcrumbList",
 "itemListElement":
 [
  {
   "@type": "ListItem",
   "position": 1,
   "item":
   {
    "@id": "https://example.com/dresses",
    "name": "Dresses"
    }
  },
  {
   "@type": "ListItem",
  "position": 2,
  "item":
   {
     "@id": "https://example.com/dresses/real",
     "name": "Real Dresses"
   }
  }
 ]*/
// Example Structured Data for Posts
/*
  "@context": "http://schema.org",

  "@type": "NewsArticle",

  "mainEntityOfPage": "https://www.recode.net/2017/6/1/15726132/donald-trump-withdraw-united-states-paris-climate-agreement-silicon-valley",

  "headline": "Apple, Facebook and Google are among the many tech giants angry with Trump’s decision to leave",

  "description": "Many in Silicon Valley urged Trump not to withdraw from the international climate pact.",

    "datePublished": "2017-06-01T15:39:05-04:00",

    "dateModified": "2017-06-01T15:39:05-04:00",

    "image": { 
    	"@type": "ImageObject", 
    	"url": "https://cdn.vox-cdn.com/thumbor/n4uZ3AiR_YUmsgqH9VlrN6_5kgw=/974x958:5039x4007/1400x1050/cdn.vox-cdn.com/uploads/chorus_image/image/55051353/688656378.0.jpg", 
    	"width": 1400, 
    	"height": 1050 
    },

  	"author": {
  		"@type": "Person",
  		"name": "Tony Romm" 
  	},

  	"publisher": {
	  	"@type": "Organization",
	    "logo": { 
	    	"@type": "ImageObject", 
	    	"url": "https://www.recode.net/v/recode/images/logos/google_amp.png", 
	    	"width": 199, 
	    	"height": 60 },
	  	"name": "Recode"
 	}
*/

// This was the data generated by us
/*
	"@context":"http:\/\/schema.org",
	"@type":"Blogposting",
	"mainEntityOfPage":"new post for alignment test",
	"Publisher":"Organization",
	"name":null,
	"logo":{"
		@type":"ImageObject",
		"url":null,
		"height":null,
		"width":null
	},

	"headline":"new post for alignment test",
	"datePublished":"April 8th 2017",
	"dateModified":"April 23rd 2017",
	"author":{"
		@type":"Person",
		"name":"mohammed kaludi"
		},
	"image":{
		"@type":"ImageObject",
		"url":"<img alt='' src='http:\/\/1.gravatar.com\/avatar\/?s=96&#038;d=mm&#038;r=g' srcset='http:\/\/1.gravatar.com\/avatar\/?s=192&amp;d=mm&amp;r=g 2x' class='avatar avatar-96 photo avatar-default' height='96' width='96' \/>"
		}

*/


//New Output generated by us

/* 
	"@context":"http:\/\/schema.org",

	"@type":"Blogposting",

	"mainEntityOfPage":"http:\/\/localhost\/wp\/egddsdgdfg\/",

	"headline":"Title of the post",

	"description":"Short summary or description of the post. ",

	  "datePublished":"May 15, 2017",

	  "dateModified":"June 3, 2017",

	  "image":{
		"@type":"ImageObject",
		"url":"http:\/\/localhost\/wp\/wp-content\/uploads\/2012\/07\/cropped-Work-at-Home-Moms.jpg",
		"width":512,
		"height":512
	  },
	
	  "author":{
		"@type":"Person",
		"name":"MARQAS"
	  },

	  "Publisher":{
		"@type":"Organization",
		"logo":{
			"@type":"ImageObject",
			"url":"http:\/\/localhost\/wp\/wp-content\/uploads\/2017\/05\/logo-retina.png",
			"width":"241",
			"height":"86"
	    },
		"name":"Blog"
	  }










*/


// @type WebSite
add_action( 'wp_head' , 'kb_website_output' );

function kb_website_output(){
	global $sd_data;
	if( (!ampforwp_sd_non_amp() && $sd_data['sd-for-ampforwp']!=1) || (ampforwp_sd_non_amp() && $sd_data['sd-for-wordpress']!=1) ) {
		return ;
	}
		$site_url = get_site_url();
		$site_name = get_bloginfo();
		$input = array(
			'@context'		=>'http://schema.org',
			'@type'			=> 'WebSite',
			'id'			=> '#website',
			'url'			=> $site_url,
			'name'			=> $site_name,
			 'potentialAction' => array(
				'@type'			=> 'SearchAction',
				'target'		=> $site_url.'/?s={search_term_string}',
				'query-input'	=> 'required name=search_term_string',
			 	)
			);
	
	echo structured_data_generator($input);	 
}

// AMP support


// add_action('init','remove_amp_sd');
// 
// function remove_amp_sd(){
// 	global $wp_filter;
// 	var_dump($wp_filter['amp_post_template_head'][10]);
// 	remove_action( 'amp_post_template_head', 'amp_post_template_add_schemaorg_metadata');
// 	$loo = has_filter('amp_post_template_head','amp_post_template_add_schemaorg_metadata');
// 	echo"ye";var_dump($loo);echo"priority";
// }

add_filter( 'amp_init', 'ampforwp_structured_data' );

function ampforwp_structured_data()
{
	
	
	add_action( 'amp_post_template_head' , 'kb_schema_output' );
	add_action( 'amp_post_template_head' , 'kb_website_output' );
	add_action( 'amp_post_template_head' , 'schema_breadcrumb_output' );
	add_action( 'amp_post_template_head' , 'schema_output' );
	add_action( 'amp_post_template_head' , 'sd_archive_output' );
	add_action( 'amp_post_template_head' , 'sd_archive_output' );
	add_action( 'amp_post_template_head' , 'sd_about_page_output' );
	add_action( 'amp_post_template_head' , 'sd_contact_page_output' );
	remove_action( 'amp_post_template_head', 'amp_post_template_add_schemaorg_metadata',10,1);
}

	
// For Archive 
add_action( 'wp_head' , 'sd_archive_output' );

function sd_archive_output(){
	global $post, $query_string, $sd_data;
	if( (!ampforwp_sd_non_amp() && $sd_data['sd-for-ampforwp']!=1) || (ampforwp_sd_non_amp() && $sd_data['sd-for-wordpress']!=1) ) {
		return ;
	}
	if(isset($sd_data['archive_schema']) && $sd_data['archive_schema'] == 1){
					
	if ( is_category() ) {
		$category_posts = array();
		$category_loop = new WP_Query( $query_string );
		if ( $category_loop->have_posts() ):
			while( $category_loop->have_posts() ): $category_loop->the_post();
				$image_id 		= get_post_thumbnail_id();
				$image_details 	= wp_get_attachment_image_src($image_id, 'full');
				$publisher_info = array(
					"type" => "Organization",
			        "name" => $sd_data['sd_name'],
			        "id"   => $sd_data['sd_url'],
			        "logo" => $sd_data['sd_logo']['url'],
				);
				$publisher_info['name'] = get_bloginfo('name');
				$publisher_info['id']	= get_the_permalink();
	            $category_posts[] =  array
	            (
					'@type' 			=> 'BlogPosting',
					'headline' 			=> get_the_title(),
					'url' 				=> get_the_permalink(),
					'datePublished' 	=> get_the_date('c'),
					'dateModified' 		=> get_the_modified_date('c'),
					'mainEntityOfPage' 	=> get_the_permalink(),
					'author' 			=> get_the_author(),
					'publisher' 		=> $publisher_info,
					'image' 			=> $image_details[0],
	            );
				
	        endwhile;

		wp_reset_postdata();
			
		$category 			= get_the_category(); 
		
		$category_id 		= intval($category[0]->term_id); 
       	$category_link 		= get_category_link( $category_id );
		$category_link 	= get_term_link( $category[0]->term_id , 'category' );
       	$category_headline 	= single_cat_title( '', false ) . __(' Category', 'schema-wp');
		// $sameAs 			= get_term_meta( $category_id, 'schema_wp_sameAs' );

		$input = array
       		(
				'@context' 		=> 'http://schema.org/',
				'@type' 		=> "CollectionPage",
				'headline' 		=> $category_headline,
				'description' 	=> strip_tags(category_description()),
				'url'		 	=> $category_link,
				'sameAs' 		=> '',
				'hasPart' 		=> $category_posts
       		);
				echo structured_data_generator($input);	
	endif;
	
		
	
	}
	} 
}

// For Author 
add_action( 'wp_head' , 'sd_author_output' );

function sd_author_output()
{
	global $post;
	if(isset($sd_data['archive_schema']) && $sd_data['archive_schema'] == 1){
	$post_id = $post->ID;
	if(is_author()){
		// Get author from post content
		$post_content	= get_post($post_id);
		$post_author	= get_userdata($content_post->post_author);
		$aurthor_name	= $post_author->display_name;
		$input = array (
			'@type'	=> 'Person',
			'name'	=> get_the_author_meta('display_name'),
			'url'	=> esc_url( get_author_posts_url( $post_author->ID ) ),

		);


		$sd_website 	= esc_attr( stripslashes( get_the_author_meta( 'user_url', $post_author->ID ) ) );
		$sd_googleplus = esc_attr( stripslashes( get_the_author_meta( 'googleplus', $post_author->ID ) ) );
		$sd_facebook 	= esc_attr( stripslashes( get_the_author_meta( 'facebook', $post_author->ID) ) );
		$sd_twitter 	= esc_attr( stripslashes( get_the_author_meta( 'twitter', $post_author->ID ) ) );
		$sd_instagram 	= esc_attr( stripslashes( get_the_author_meta( 'instagram', $post_author->ID ) ) );
		$sd_youtube 	= esc_attr( stripslashes( get_the_author_meta( 'youtube', $post_author->ID ) ) );
		$sd_linkedin 	= esc_attr( stripslashes( get_the_author_meta( 'linkedin', $post_author->ID ) ) );
		$sd_pinterest 	= esc_attr( stripslashes( get_the_author_meta( 'pinterest', $post_author->ID ) ) );
		$sd_soundcloud = esc_attr( stripslashes( get_the_author_meta( 'soundcloud', $post_author->ID ) ) );
		$sd_tumblr 	= esc_attr( stripslashes( get_the_author_meta( 'tumblr', $post_author->ID ) ) );
		
		$sd_sameAs_links = array( $sd_website, $sd_googleplus, $sd_facebook, $sd_twitter, $sd_instagram, $sd_youtube, $sd_linkedin, $sd_pinterest, $sd_soundcloud, $sd_tumblr);
		
		$sd_social = array();
		
		// Remove empty fields
		foreach( $sd_sameAs_links as $sd_sameAs_link ) {
			if ( '' != $sd_sameAs_link ) $sd_social[] = $sd_sameAs_link;
		}
		
		if ( ! empty($sd_social) ) {
			$input["sameAs"] = $sd_social;
		}

		if ( get_the_author_meta( 'description', $post_author->ID ) ) {
			$input['description'] = strip_tags( get_the_author_meta( 'description', $post_author->ID ) );
		}
		echo structured_data_generator($input);
	}
 }
}

// For About Page
add_action( 'wp_head' , 'sd_about_page_output' );

function sd_about_page_output()
{
	global $sd_data;
	$image_id 		= get_post_thumbnail_id();
	$image_details 	= wp_get_attachment_image_src($image_id, 'full');
	if(isset($image_details['url'])){
				$image_url		= $image_details['url'];
			}
	$about_page = $sd_data['sd_about_page'];

	if(isset($sd_data['sd_about_page']) && $sd_data['sd_about_page'] === get_the_ID()){

			$logo = $sd_data['sd_logo']['url'];	
			$height = $sd_data['sd_logo']['height'];
			$width = $sd_data['sd_logo']['width'];

				if( '' ==  $image_details && empty($image_details) && isset($sd_data['sd_default_image'])){
					$image_url = $sd_data['sd_default_image']['url'];
				}
				
				if( '' ==  $image_details && empty($image_details) && isset($sd_data['sd_default_image_height'])){
					$height = $sd_data['sd_default_image_height'];
				}
				
				if( '' ==  $image_details && empty($image_details) && isset($sd_data['sd_default_image_width'])){
					$width = $sd_data['sd_default_image_width'];
				}
			$input = array(
				"@context" 	 		=> "http://schema.org",
				"@type"				=> "AboutPage",
				"mainEntityOfPage"  => array(
							"@type" => "WebPage",
							"@id" 	=> $get_permalink(),
							),
				"url"				=> $about_page,
				"headline"			=> get_the_title(),
				"image"				=> array(
							"@type"		=> "ImageObject",
				    		"url"		=> $image_url,
				    		"width"		=> $widht,
							"height"	=> $height,
							),
				'Publisher'				=> array(
						'@type'			=> 'Organization',
						'logo' 			=> array(
							'@type'		=> 'ImageObject',
							'url'		=> $logo,
							'width'		=> $width,
							'height'	=> $height,
							),
						'name'			=> $sd_data['sd_name'],
						),
				'description'			=> get_the_excerpt(),

			);
			
			echo structured_data_generator($input);
	}
	
}

// For Contact Page
add_action( 'wp_head' , 'sd_contact_page_output' );

function sd_contact_page_output()
{
	global $sd_data;
	$image_id 		= get_post_thumbnail_id();
	$image_details 	= wp_get_attachment_image_src($image_id, 'full');
	if(isset($image_details['url'])){
				$image_url		= $image_details['url'];
			}
	$contact_page = $sd_data['sd_contact_page'];

	if(isset($sd_data['sd_contact_page']) && $sd_data['sd_contact_page'] === get_the_ID()){

			$logo = $sd_data['sd_logo']['url'];	
			$height = $sd_data['sd_logo']['height'];
			$width = $sd_data['sd_logo']['width'];

				if( '' ==  $image_details && empty($image_details) && isset($sd_data['sd_default_image'])){
					$image_url = $sd_data['sd_default_image']['url'];
				}
				
				if( '' ==  $image_details && empty($image_details) && isset($sd_data['sd_default_image_height'])){
					$height = $sd_data['sd_default_image_height'];
				}
				
				if( '' ==  $image_details && empty($image_details) && isset($sd_data['sd_default_image_width'])){
					$width = $sd_data['sd_default_image_width'];
				}
			$input = array(
				"@context" 	 		=> "http://schema.org",
				"@type"				=> "ContactPage",
				"mainEntityOfPage"  => array(
							"@type" => "WebPage",
							"@id" 	=> get_permalink(),
							),
				"url"				=> $about_page,
				"headline"			=> get_the_title(),
				"image"				=> array(
							"@type"		=> "ImageObject",
				    		"url"		=> $image_url,
				    		"width"		=> $widht,
							"height"	=> $height,
							),
				'Publisher'				=> array(
						'@type'			=> 'Organization',
						'logo' 			=> array(
							'@type'		=> 'ImageObject',
							'url'		=> $logo,
							'width'		=> $width,
							'height'	=> $height,
							),
						'name'			=> $sd_data['sd_name'],
						),
				'description'			=> get_the_excerpt(),

			);
			
			echo structured_data_generator($input);
	}
	
}