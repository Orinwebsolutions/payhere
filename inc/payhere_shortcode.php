<?php
/*
 * payhere Shortcode
 * A shortcode created to redirect to submition form
 */

 
 //defines the functionality for the payhere shortcode
 class payhere_shortcode{
 	
     
	//on initialize
	public function __construct(){
		add_action('init', array($this,'register_payhere_shortcodes')); //shortcodes
	}

	//payhere shortcode
	public function register_payhere_shortcodes(){
		add_shortcode('payhereImage', array($this,'payhere_shortcode_output'));
//		add_shortcode('payhereImage', array($this,'image_code'));
//            add_shortcode('payhereImage', 'image_code');                
	}
	
	//shortcode display
	public function payhere_shortcode_output($url = ''){

            $url = functionPayhereForm();
            $image = plugin_dir_url( dirname( __FILE__ ) ) .'images/logo.png';
            $id = get_the_ID();//To retrieve the page/post id
            $ItemName = get_the_title($id);
            $classORid= 'value123';
            $CurrencyCode = 'Rs';
            
        //return "<a id='opener' href=''><img src='http://localhost/WordPressPlugin/wp-content/uploads/2016/10/Evenements_Maha-Saman-Devale-Perahera_6.jpg' height=10 class='user-imgs' /></a><p>Test</p></a>". $url;
        return "<img id='opener' src='".$image."' width=100 class='user-imgs' />". $url.
                "<input type='hidden' name='pageid' id='pageid' value='".$id."'/>
                <input type='hidden' id='classORid' name='classORid' value='".$classORid."'/>
                <input type='hidden' id='ItemName' name='ItemName' value='".$ItemName."'/>    
                <input type='hidden' id='CurrencyCode' name='CurrencyCode' value='".$CurrencyCode."'/>";
	}
        

        

 }
 $payhere_shortcode = new payhere_shortcode;

 include(plugin_dir_path(__FILE__) . '../public/payhere-form.php' ); 

?>