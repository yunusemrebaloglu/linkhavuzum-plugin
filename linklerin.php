<?php 
// bu sayfada kimi bağzı php işlemleri yapacağımdan ayrı sayfada yaptım ki ben yaptıysam büyük ihtimal saçmadır 

// linklerimizi eklemek için gerekli olan formumuzu çağırdık.
include 'views/link_add.php'; 

global $wpdb;
if (!empty($_POST)) {
// post gelmiş ise ya save için ya da update içindir oyuzden fonksiyonlamış olduğumuz saup fonksiyonumuzu çağırıyoruz
	saup();

}

if (isset($_GET['delete'])) {
// eğer get aracılığı ile bir delete değeri geldiyse o değeri bul ve bam bam bam.
	deletelink($_GET['delete']);	
}

// bu sayfanın asıl amacı olan bütün kayıt edilen linkleri göstermek için hepsini alıp düngüyle bir bir ekrana yazdırdık
multicard();