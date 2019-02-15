<?php 
// Admin Menüsüne eklentimizi eklemek için yazılan yer.
function admin_menu_ekle(){
	add_menu_page('Linklerin','Link Havuzum', 'manage_options', 'eklenti-flu/linklerin.php', '',"", 80);

}
// eklentimiz kurulduğu anda eklentimiz için için gerekli olan veri tabanını oluşturmak için yazılan yer.
function myplugin_activate() {

	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
//veri tabanımızda id, link, içerik, ve tarih olmak üzere yerler yarattık.
	$sql = "CREATE TABLE wp_linkim (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	link text NOT NULL,
	content text NOT NULL,
	title text NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}


// Eğer eklentimiz silinirse yaratmış olduğumuz veritabanımızı içeriğindeki bütün bilgiler ile birlikte silsin.
function your_prefix_uninstall(){
	global $wpdb;
	$wpdb->query('DROP TABLE wp_linkim');
}


// eklentimiz için istemiş olduğumuz linkten yola çıkarak sitenin istediğimiz değer aralıklarını çeken kısım.
function ara($bas, $son, $yazi)
{ 
	@preg_match_all('/' . preg_quote($bas, '/') .
		'(.*?)'. preg_quote($son, '/').'/i', $yazi, $m);
	// var_dump($m[1][0]);
	return @$m[1];
}



// içerisine gelen id = $content değişkeni ile istenilen linkin bilgilerini ekrana basmak için yazılan yer.
function findlinkim( $atts, $content = "" ) {
	if (is_single() or is_page()) {
		
		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM wp_linkim where id =".$content , OBJECT );
//veritabanımızda bize gelen id = $content ile aratma yapıp foreach döngüsüne soktuk.
		foreach ($results as $key) {
	//daha sonra ekrana basmak istediğimiz kısmı return ettik
			return '
							<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
							<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
							<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
							<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

							<div class="col-6">
							    	<div class="row">
										    <div class="col-12">
										    	<div class="row">
											    	<div class="col-8">
													<a href="<?=$key->link?>">'.$key->title.'</a>
													
													<br>
											    	'.$key->content.'<br>
											    	</div>
										    	</div>
										    </div>
								    </div>
							    </div>';
		}
	}

	
}
// Girilen Url'nin Gerçekliğine Baktık
function url_var($adres){
	$ch = curl_init($adres);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_exec($ch);
	$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);    
	curl_close($ch);
	if($retcode==200)
	{
		return true;
	}else{            
		return false;
	}
}
// meta bax kutumuzu ekleyip
function my_meta_box(){
 	add_meta_box('link', __('Linkleriniz', 'linkleriniz.'), 'my_meta_box_id','','side');
}
// meta bax kutumuzda linklerimizin kısa yolu olacağına dair bilgileri koyduk
function my_meta_box_id(){

		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM wp_linkim order by id desc" , OBJECT );

	foreach ($results as $key) {


		include 'views/view_meta_box.php';
	}




}
function saup(){


if (url_var($_POST['link'])) {
		// girilen linkin varlığını url_var fonkisoynu ile test edip eğer site var ise devam etsin dedik ve sonrasında girilen url den giderek istenilen sitenin titlenı aldık veri tabanımıza kayıt ettik.
		$icerik = file_get_contents($_POST['link']);
		$title = ara('<title>','</title>', $icerik);
		
	// eğer formlardan biri ya güncelleme ya da yeni kayıt formlarından birisi doldurulmuşsa ve gönderilmişse 
		if (isset($_POST['update'])) {
			global $wpdb;
		// güncelleme formunun çalıştığını anlamak için içeriye koymuş olduğumuz update değeri aktif ise güncelleme işlemini çalıştır dedik
			$wpdb->update( 
				'wp_linkim', 
				array( 
					'link' => $_POST['link'],
					'created_at' => '',
					'content' => $_POST['content'],
					'title' => $title[0],

				), 
				array( 'id' => $_POST['id'] ), 
				array( 
					'%s',	
					'%d'	
				), 
				array( '%d' ) 
			);
		}else{
		// değilse yani içeride güncellemeye dair bir değer bulamadıysa yeni kayıt bu ozaman diyerek buraya yeni kayıt ekle dedik
			global $wpdb;
			$data = array(
				'link' => $_POST['link'], 
				'created_at' => "", 
				'content'=> $_POST['content'], 
				'title' => $title[0]
			);
			$format = array('%s','%d');
			$wpdb->insert('wp_linkim',$data,$format);
			$my_id = $wpdb->insert_id;
		}
	}else{
		echo "Malesef Aramış Olduğunuz İnternet Sitesi Bulunamadı. <br><br><br>";
	}
}
function deletelink($d){
	global $wpdb;		
	$wpdb->delete( 'wp_linkim', array( 'id' => $d ) );
	// header("location: index.php");
}


function multicard(){
global $wpdb;

$results = $wpdb->get_results( "SELECT * FROM wp_linkim order by id desc" , OBJECT );

echo '<div class="container">
<div class="row">';
$i = 1;
foreach ($results as $key) {

	// $id = $key->id;
// $i değeri ekrana bastığımız modalda hepsi tek bir modalı belli etmesin diyerek modalın id'sini değiştirmek için yapılmış bir şey.
	$i = $i+1;
	include 'views/card_admin.php';
}

echo '</div>
</div>';


}
