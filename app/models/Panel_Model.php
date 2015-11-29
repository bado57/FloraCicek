<?php

class Panel_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function select() {
        $sql = "SELECT * FROM table";
        return $this->db->select($sql);
    }

    public function insert($data) {
        return ($this->db->insert("table", $data));
    }

    public function update($data, $gelenid) {
        return ($this->db->update("table", $data, "table_id=$gelenid"));
    }

    public function delete($gelenid) {
        return ($this->db->delete("table", "table_id=$gelenid"));
    }

    //sabit içerikler listeleme
    public function sabiticeriklistele() {
        $sql = "SELECT sbt_telefon,sbt_iletisimmail,sbt_face,sbt_twit,sbt_instag,sbt_gplus,sbt_logo FROM flora_sabiticerik";
        return $this->db->select($sql);
    }

    //sabit içerikler listeleme
    public function sabiticerikcontactlistele() {
        $sql = "SELECT sbt_telefon,sbt_fax,sbt_adres,sbt_haritaiframe,sbt_iletisimmail,sbt_face,sbt_twit,sbt_instag,sbt_gplus,sbt_logo FROM flora_sabiticerik";
        return $this->db->select($sql);
    }

    //kategori adı ayırt etme
    public function secimlistele($isim) {
        $sql = "SELECT kategoriAd,kategoriID,kategoriTip FROM flora_kategorisim WHERE kategoriAd='$isim'";
        return $this->db->select($sql);
    }

    //kategori adı ayırt etme
    public function secimSayfalistele($isim) {
        $sql = "SELECT kategoriAd,kategoriID,kategoriTip FROM flora_kategorisim WHERE kategoriAd='$isim'";
        return $this->db->select($sql);
    }

    //home etiket listeleme
    public function etiketlistele() {
        $sql = "SELECT etiket_id,etiket_adi,etiket_benzad FROM flora_etiket WHERE etiket_aktiflik=1 ORDER BY etiket_sira ASC ";
        return $this->db->select($sql);
    }

    //home kategori listeleme
    public function kategorilistele() {
        $sql = "SELECT kategori_ID,kategori_Adi,kategori_BenzAd,kategori_Sira,kategori_UstID FROM flora_kategori WHERE kategori_Aktiflik=1 ORDER BY kategori_Sira ASC";
        return $this->db->select($sql);
    }

    //kampanya listeleme
    public function kampanyalistele() {
        $sql = "SELECT kampanya_ID,kampanya_baslik,kampanya_benbaslik FROM flora_kampanya WHERE kampanya_aktiflik=1";
        return $this->db->select($sql);
    }

    //vitrin listeleme
    public function vitrinlistele() {
        $sql = "SELECT vitrin_ID,vitrin_resimpath,vitrin_baslik,vitrin_yazi,vitrin_url,vitrin_altbaslik,vitrin_buttonyazi FROM flora_vitrin WHERE vitrin_aktiflik=1 ORDER BY vitrin_sira ASC";
        return $this->db->select($sql);
    }

    //ürün listeleme
    public function urunlistele() {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_yeniurun,urun_ekurun,urun_adi,urun_benzad,urun_benzad,urun_kmpnyaid,urun_hafta,urun_anaresim,urun_coksatan FROM flora_urun WHERE urun_aktiflik=1";
        return $this->db->select($sql);
    }

    //ürün kampanya detay listeleme
    public function urunkampanyalistele($array = array(), $tarih) {
        $sql = "SELECT kampanya_ID,kampanya_indirimyuzde FROM flora_kampanya WHERE kampanya_ID IN ($array) AND kampanya_aktiflik=1 AND kampanya_baslamatarih<" . $tarih . "<kampanya_bitistarihi";
        return $this->db->select($sql);
    }

    //kategori detay listeleme
    public function kategoridetaylistele($katID) {
        $sql = "SELECT kategori_ID,kategori_Adi,kategori_Yazi,kategori_Resim FROM flora_kategori WHERE kategori_ID=" . $katID;
        return $this->db->select($sql);
    }

    //kategori urun listeleme
    public function kategoriurunlistele($katID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_kategoriID=$katID AND urun_aktiflik=1 ORDER BY urun_coksatan DESC";
        return $this->db->select($sql);
    }

    //kategori urun çok satanlar listeleme
    public function kategoricsurunlistele($katID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_kategoriID=$katID AND urun_aktiflik=1 ORDER BY urun_coksatan DESC";
        return $this->db->select($sql);
    }

    //kategori urun ucuzdan pahalıya listeleme
    public function kategoriupurunlistele($katID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_kategoriID=$katID AND urun_aktiflik=1 ORDER BY urun_fiyat ASC";
        return $this->db->select($sql);
    }

    //kategori urun pahalıdan ucuza listeleme
    public function kategoripuurunlistele($katID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_kategoriID=$katID AND urun_aktiflik=1 ORDER BY urun_fiyat DESC";
        return $this->db->select($sql);
    }

    //kategori urun adan zye listeleme
    public function kategoriazurunlistele($katID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_kategoriID=$katID AND urun_aktiflik=1 ORDER BY urun_adi ASC";
        return $this->db->select($sql);
    }

    //kategori detay listeleme
    public function katkampanyadetaylistele($katAd, $tarih) {
        $sql = "SELECT kampanya_ID,kampanya_baslik,kampanya_benbaslik,kampanya_yazi,kampanya_resim,kampanya_indirimyuzde FROM flora_kampanya WHERE kampanya_benbaslik=$katAd AND kampanya_aktiflik=1 AND kampanya_baslamatarih<" . $tarih . "<kampanya_bitistarihi";
        return $this->db->select($sql);
    }

    //kampanya urun listeleme
    public function katkampanyaurunlistele($kmpnyaID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_kmpnyaid=$kmpnyaID AND urun_aktiflik=1 ORDER BY urun_coksatan DESC";
        return $this->db->select($sql);
    }

    //kampanya urun listeleme ucuzdan pahalıya
    public function katkampanyaupurunlistele($kmpnyaID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad FROM flora_urun WHERE urun_kmpnyaid=$kmpnyaID AND urun_aktiflik=1 ORDER BY urun_fiyat ASC";
        return $this->db->select($sql);
    }

    //kampanya urun listeleme pahalıdan ucuza
    public function katkampanyapuurunlistele($kmpnyaID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad FROM flora_urun WHERE urun_kmpnyaid=$kmpnyaID AND urun_aktiflik=1 ORDER BY urun_fiyat DESC";
        return $this->db->select($sql);
    }

    //kampanya urun listeleme Adan Zye
    public function katkampanyaazurunlistele($kmpnyaID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad FROM flora_urun WHERE urun_kmpnyaid=$kmpnyaID AND urun_aktiflik=1 ORDER BY urun_adi ASC";
        return $this->db->select($sql);
    }

    //etiket kategorisi detay listeleme
    public function kategorietiketdetaylistele($katID) {
        $sql = "SELECT etiket_id,etiket_adi,etiket_yazi FROM flora_etiket WHERE etiket_id=$katID AND etiket_aktiflik=1";
        return $this->db->select($sql);
    }

    //etiket ürün idler
    public function kategorietiketurunid($katID) {
        $sql = "SELECT urunetiket_UrunID FROM flora_urunetiket WHERE urunetiket_EtiketID=$katID";
        return $this->db->select($sql);
    }

    //kategori urun listeleme çoktan aza
    public function etiketuruncslistele($array = array()) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_ID IN ($array) AND urun_aktiflik=1 ORDER BY urun_coksatan DESC";
        return $this->db->select($sql);
    }

    //kategori urun listeleme ucuzdan pahalıya
    public function etiketurunuplistele($array = array()) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_ID IN ($array) AND urun_aktiflik=1 ORDER BY urun_fiyat ASC";
        return $this->db->select($sql);
    }

    //kategori urun listeleme pahalıdan ucuza
    public function etiketurunpulistele($array = array()) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_ID IN ($array) AND urun_aktiflik=1 ORDER BY urun_fiyat DESC";
        return $this->db->select($sql);
    }

    //kategori urun listeleme adan zye
    public function etiketurunazlistele($array = array()) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_ID IN ($array) AND urun_aktiflik=1 ORDER BY urun_adi ASC";
        return $this->db->select($sql);
    }

    //urun detay listeleme
    public function urundetaylistele($urunKod) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_benzersizkod,urun_aciklama,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_benzersizkod=$urunKod AND urun_aktiflik=1";
        return $this->db->select($sql);
    }

    //tek ürün kampanya detay listeleme
    public function urunkampanya($kid, $tarih) {
        $sql = "SELECT kampanya_ID,kampanya_indirimyuzde FROM flora_kampanya WHERE kampanya_ID=$kid AND kampanya_aktiflik=1 AND kampanya_baslamatarih<" . $tarih . "<kampanya_bitistarihi";
        return $this->db->select($sql);
    }

    //ürün iller listeleme
    public function urunIlListele() {
        $sql = "SELECT sehir_id,sehir_adi FROM flora_sehir WHERE sehir_aktiflik=1";
        return $this->db->select($sql);
    }

    //ürün ilçeler listeleme
    public function urunIlceListele($ilid) {
        $sql = "SELECT ilce_id,ilce_adi,ilce_ekucret FROM flora_ilce WHERE ilce_aktiflik=1 AND ilce_sehirid= $ilid";
        return $this->db->select($sql);
    }

    //ürün ilçeler fiyat listeleme
    public function urunIlceFiyatListele($ilceid) {
        $sql = "SELECT ilce_ekucret,ilce_adi FROM flora_ilce WHERE ilce_id= $ilceid";
        return $this->db->select($sql);
    }

    //ürün semtler listeleme
    public function urunSemtListele($ilceid) {
        $sql = "SELECT semt_ilceID,semt_ad FROM flora_semt WHERE semt_ilceID= $ilceid";
        return $this->db->select($sql);
    }

    //ürün mahalle listeleme
    public function urunMahalleListele($semtid) {
        $sql = "SELECT flora_mahalleID,flora_mahallead FROM flora_mahalle WHERE flora_semtID= $semtid";
        return $this->db->select($sql);
    }

    //ürün posta kodu listeleme
    public function urunPKoduListele($mahalleid) {
        $sql = "SELECT pkID,pk_kod FROM flora_postakodu WHERE pk_mahalleID= $mahalleid";
        return $this->db->select($sql);
    }

    //urun siparis detay listeleme
    public function urundetaysiparis($urunID) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_aciklama,urun_fiyat,urun_anaresim,urun_adi,urun_benzad,urun_kmpnyaid FROM flora_urun WHERE urun_ID=$urunID AND urun_aktiflik=1";
        return $this->db->select($sql);
    }

    //ek ürün listeleme
    public function ekurunlistele() {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_adi,urun_benzad,urun_kmpnyaid,urun_anaresim FROM flora_urun WHERE urun_ekurun=1 AND urun_aktiflik=1 ";
        return $this->db->select($sql);
    }

    //kampanyalı ürün listeleme
    public function kampanyaliurunlistele() {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_adi,urun_benzad,urun_kmpnyaid,urun_anaresim FROM flora_urun WHERE urun_kmpnyaid=1 AND urun_aktiflik=1 ";
        return $this->db->select($sql);
    }

    //çok satan ürün listeleme
    public function coksatanurunlistele() {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_adi,urun_benzad,urun_kmpnyaid,urun_anaresim FROM flora_urun WHERE urun_coksatan=1 AND urun_aktiflik=1 ";
        return $this->db->select($sql);
    }

    //giriş yap sorgulama
    public function girisSorgu($email, $realsifre) {
        $sql = "SELECT kullanici_id,kullanici_adSoyad,kullanici_eposta,kullanici_vergid,kullanici_vergino,kullanici_adres,kullanici_rol FROM flora_kullanici WHERE kullanici_eposta='$email' AND kullanici_sifre='$realsifre'";
        return $this->db->select($sql);
    }

    //email kontrol etme
    public function emailDbKontrol($email) {
        $sql = "SELECT kullanici_id,kullanici_adSoyad,kullanici_realsifre FROM flora_kullanici WHERE kullanici_eposta='$email'";
        return $this->db->select($sql);
    }

    //mail havuz email kontrol etme
    public function ebultenDbKontrol($email) {
        $sql = "SELECT mailhavuz_ID FROM flora_mailhavuz WHERE mailhavuz_Mail='$email'";
        return $this->db->select($sql);
    }

    //bireysel üyeleri kaydetme
    public function birUye($data) {
        return ($this->db->insert("flora_kullanici", $data));
    }

    //mail havuzuna mailleri kaydetme
    public function mailHavuzInsert($data) {
        return ($this->db->insert("flora_mailhavuz", $data));
    }

    //kurumsal üyeleri kaydetme
    public function kurUye($data) {
        return ($this->db->insert("flora_kullanici", $data));
    }

    //üuelik sözleşmesi 
    public function uyelikSozlistele() {
        $sql = "SELECT sbt_uyeliksoz FROM flora_sabiticerik";
        return $this->db->select($sql);
    }

    //gönderim yeri
    public function gonderimYeri() {
        $sql = "SELECT gonderimyeri_ID,gonderimyeri_adi FROM flora_gonderimyeri WHERE gonderimyeri_aktif=1 ORDER BY gonderimyeri_adi ASC";
        return $this->db->select($sql);
    }

    //gönderim nedeni
    public function gonderimNeden() {
        $sql = "SELECT gonderimnedeni_ID,gonderimnedeni_adi FROM flora_gonderimnedeni WHERE gonderimnedeni_aktif=1 ORDER BY gonderimnedeni_adi ASC";
        return $this->db->select($sql);
    }

    //ek ürün bazılarını listeleme
    public function ekurunbazilistele($array = array()) {
        $sql = "SELECT urun_ID,urun_kodu,urun_benzersizkod,urun_fiyat,urun_adi,urun_benzad,urun_kmpnyaid,urun_anaresim FROM flora_urun WHERE urun_ID IN ($array) AND urun_ekurun=1 AND urun_aktiflik=1 ";
        return $this->db->select($sql);
    }

    //sipariş teslimat bilgileri
    public function sipTeslimat($data) {
        return ($this->db->insert("flora_gecicisiparis", $data));
    }

    //sipariş real insert
    public function sipRealInsert($data) {
        return ($this->db->insert("flora_siparis", $data));
    }

    //sipariş ana ürün insert
    public function sipAnaUrunInsert($data) {
        return ($this->db->insert("flora_siparisurun", $data));
    }

    //sipariş ek ürün insert
    public function sipEkUrunInsert($data) {
        return ($this->db->multiInsert('flora_siparisurun', $data));
    }

    //ürün siparis benzersiz Kod Kontrolü
    public function siparisBenzersizKontrol($kod) {
        $sql = "SELECT siparis_ID FROM flora_siparis WHERE siparis_No=$kod";
        return $this->db->select($sql);
    }

    //geçicci Sipariş Bilgileri Getirme
    public function geciciSiparis($id) {
        $sql = "SELECT * FROM flora_gecicisiparis WHERE siparis_ID=$id";
        return $this->db->select($sql);
    }

    //son eklenilen siparişi silme
    public function siparisDelete($gelenid) {
        return ($this->db->delete("flora_siparis", "siparis_ID=$gelenid"));
    }

    //eçici Sipariş Tablosunu Boşaltma
    public function geciciSiparisFullDelete() {
        return ($this->db->delete("flora_gecicisiparis", "siparis_ID>0"));
    }

    public function bankaFrontListele() {
        $sql = "SELECT banka_ID,banka_adi,banka_aktif,banka_sube,banka_hesapno,banka_ibanno,banka_alici FROM flora_banka WHERE banka_aktif=1 ORDER BY banka_adi ASC";
        return $this->db->select($sql);
    }

    //mesafeli sözleşmesi 
    public function mesafeliSozlistele() {
        $sql = "SELECT sbt_mesafelistssoz FROM flora_sabiticerik";
        return $this->db->select($sql);
    }

    //home footer kategori listeleme
    public function footerkategorilistele() {
        $sql = "SELECT sabitsayfaid,sayfa_UstID,sbtsayfa_Sira,sbtsayfa_Adi,sbtsayfa_bnzrszAd FROM flora_sabitsayfa WHERE sbtsayfa_Aktiflik=1 ORDER BY sbtsayfa_Sira ASC";
        return $this->db->select($sql);
    }

    //sabit sayfa içerikler ilistelem
    public function sabitsayfaicerik($icerikAd) {
        $sql = "SELECT sabitsayfaid,sayfa_Resim,sayfa_Yazi,sbtsayfa_Adi FROM flora_sabitsayfa WHERE sbtsayfa_Aktiflik=1 AND sbtsayfa_bnzrszAd='$icerikAd'";
        return $this->db->select($sql);
    }

    //blog sayfa içerikleri listeleme
    public function blogicerik() {
        $sql = "SELECT blog_ID,blog_baslik,blog_benzersizbaslik,blog_yazi,blog_tarih,blog_resim,blog_ay,blog_yil FROM flora_blog WHERE blog_aktiflik=1 ORDER BY blog_tarih DESC";
        return $this->db->select($sql);
    }

    //blog sayfa içerikleri listeleme
    public function blogicerikAy() {
        $sql = "SELECT DISTINCT blog_ay,blog_yil FROM flora_blog WHERE blog_aktiflik=1";
        return $this->db->select($sql);
    }

    //blog sayfa içerikleri listeleme
    public function blogicerikYil() {
        $sql = "SELECT DISTINCT blog_yil FROM flora_blog WHERE blog_aktiflik=1";
        return $this->db->select($sql);
    }

    //blog sayfa içerikleri listeleme
    public function blogtekilicerik($ad) {
        $sql = "SELECT blog_ID,blog_baslik,blog_benzersizbaslik,blog_yazi,blog_tarih,blog_resim,blog_ay,blog_yil FROM flora_blog WHERE blog_aktiflik=1 AND blog_benzersizbaslik='$ad' ORDER BY blog_tarih DESC";
        return $this->db->select($sql);
    }

    //panel üe count
    public function adminPanelUyeCount() {
        $sql = "SELECT kullanici_rol FROM flora_kullanici";
        return $this->db->select($sql);
    }

    //panel ürün count
    public function adminPanelUrunCount() {
        $sql = "SELECT count(*) as total FROM flora_siparis WHERE siparis_durum=0";
        return $this->db->select($sql);
    }

    //panel üye son
    public function adminPanelUyeSon() {
        $sql = "SELECT kullanici_id,kullanici_adSoyad,kullanici_eposta,kullanici_rol FROM flora_kullanici WHERE kullanici_rol !=1 ORDER BY kullanici_id DESC";
        return $this->db->select($sql);
    }

    //panel ürün son
    public function adminPanelUrunSon() {
        $sql = "SELECT siparis_ID,siparis_sehir,siparis_ilce,siparis_toplamtutar,siparis_girilmetarih,siparis_durum FROM flora_siparis ORDER BY siparis_girilmetarih DESC";
        return $this->db->select($sql);
    }

    //panel ürün son
    public function adminPanelUrunSonID($array = array()) {
        $sql = "SELECT siparis_ID,siparis_sehir,siparis_ilce,siparis_toplamtutar,siparis_girilmetarih,siparis_durum FROM flora_siparisurun WHERE siparisurun_siparisID IN ($array)";
        return $this->db->select($sql);
    }

    //home kategori listeleme
    public function adminKategorilistele() {
        $sql = "SELECT kategori_ID,kategori_Adi,kategori_Yazi,kategori_Aktiflik,kategori_Sira,kategori_UstID FROM flora_kategori ORDER BY kategori_Sira ASC";
        return $this->db->select($sql);
    }

    public function altkategorisiraUpdate($data, $gelenid) {
        return ($this->db->update("flora_kategori", $data, "kategori_ID=$gelenid"));
    }

    //üst kataegorisi olana alt kategori ekleme
    public function altKategoriEkleUstte($data) {
        return ($this->db->insert("flora_kategori", $data));
    }

    //kampanya ekleme
    public function kampanyaEkle($data) {
        return ($this->db->insert("flora_kampanya", $data));
    }

    //üst kataegorisi olana alt kategori ekleme
    public function kategoriIsimEkle($data) {
        return ($this->db->insert("flora_kategorisim", $data));
    }

    public function kategoriBenzersizKontrol($katAdi) {
        $sql = "SELECT kategori_ID FROM flora_kategori WHERE  kategori_BenzAd='$katAdi'";
        return $this->db->select($sql);
    }

    public function etiketBenzersizKontrol($katAdi) {
        $sql = "SELECT etiket_id FROM  flora_etiket WHERE  etiket_benzad='$katAdi'";
        return $this->db->select($sql);
    }

    public function kategoriIsımDuzenle($data, $gelenid) {
        return ($this->db->update("flora_kategorisim", $data, "kategoriID=$gelenid"));
    }

    public function kategoriIsimDelete($gelenid) {
        return ($this->db->delete("flora_kategorisim", "kategoriID=$gelenid"));
    }

    //ürün benzersiz Kod Kontrolü
    public function urunBenzersizKontrol($kod) {
        $sql = "SELECT urun_ID FROM flora_urun WHERE urun_benzersizkod=$kod";
        return $this->db->select($sql);
    }

    public function sayfaBenzersizKontrol($sayfaAdi) {
        $sql = "SELECT sabitsayfaid FROM flora_sabitsayfa WHERE sbtsayfa_bnzrszAd='$sayfaAdi'";
        return $this->db->select($sql);
    }

    public function blogBenzersizKontrol($sayfaAdi) {
        $sql = "SELECT blog_ID FROM flora_blog WHERE blog_benzersizbaslik='$sayfaAdi'";
        return $this->db->select($sql);
    }

    public function ustkategorisiraUpdate($data, $gelenid) {
        return ($this->db->update("flora_kategori", $data, "kategori_ID=$gelenid"));
    }

    public function panelkategoriurunUpdate($data, $gelenid) {
        return ($this->db->update("flora_urun", $data, "urun_kategoriID=$gelenid"));
    }

    public function altKategoriDelete($gelenid) {
        return ($this->db->delete("flora_kategori", "kategori_ID=$gelenid"));
    }

    public function ustAltKategoriDelete($gelenid) {
        return ($this->db->delete("flora_kategori", "kategori_UstID=$gelenid"));
    }

    public function ustKategoriDelete($gelenid) {
        return ($this->db->delete("flora_kategori", "kategori_ID=$gelenid"));
    }

    //home kategori listeleme
    public function urunKategorilistele() {
        $sql = "SELECT kategori_ID,kategori_Adi,kategori_Yazi,kategori_Aktiflik,kategori_Sira,kategori_UstID FROM flora_kategori WHERE kategori_Aktiflik=1 AND kategori_UstID !=0 ORDER BY kategori_Sira ASC";
        return $this->db->select($sql);
    }

    //ürün listeleme
    public function panelurunlistele() {
        $sql = "SELECT urun_ID,urun_kategoriID,urun_kategoriAd,urun_kodu,urun_aktiflik,urun_sira,urun_yeniurun,urun_ekurun,urun_adi,urun_kmpnyaid,urun_hafta,urun_coksatan FROM flora_urun ORDER BY urun_kodu ASC";
        return $this->db->select($sql);
    }

    //etiket kategori listeleme
    public function adminEtiketlistele() {
        $sql = "SELECT etiket_id,etiket_adi FROM  flora_etiket WHERE etiket_aktiflik=1 ORDER BY etiket_sira ASC";
        return $this->db->select($sql);
    }

    //ürün ekleme
    public function panelUrunEkle($data) {
        return ($this->db->insert("flora_urun", $data));
    }

    //ürün etiket 
    public function panelMultiUrunEtiket($data) {
        return ($this->db->multiInsert('flora_urunetiket', $data));
    }

    public function urunSiraUpdate($data, $gelenid) {
        return ($this->db->update("flora_urun", $data, "urun_ID=$gelenid"));
    }

    public function urunHaftaUpdate($data) {
        return ($this->db->update("flora_urun", $data, "urun_ID>0"));
    }

    public function urunDelete($gelenid) {
        return ($this->db->delete("flora_urun", "urun_ID=$gelenid"));
    }

    public function urunEtiketDelete($gelenid) {
        return ($this->db->delete("flora_urunetiket", "urunetiket_UrunID=$gelenid"));
    }

    //ürün listeleme
    public function panelurunDuzenlistele($id) {
        $sql = "SELECT urun_ID,urun_kategoriID,urun_kategoriAd,urun_kodu,urun_aciklama,urun_fiyat,urun_normalfiyat,urun_aktiflik,urun_sira,urun_yeniurun,urun_ekurun,urun_adi,urun_kmpnyaid,urun_hafta,urun_anaresim,urun_coksatan FROM flora_urun WHERE urun_ID=$id";
        return $this->db->select($sql);
    }

    //etiket ürün listeleme
    public function urunEtiketListe($id) {
        $sql = "SELECT urunetiket_UrunID,urunetiket_EtiketID FROM  flora_urunetiket WHERE urunetiket_UrunID=$id";
        return $this->db->select($sql);
    }

    public function panelurunUpdate($data, $gelenid) {
        return ($this->db->update("flora_urun", $data, "urun_ID=$gelenid"));
    }

    //home kategori listeleme
    public function paneletiketlistele() {
        $sql = "SELECT etiket_id,etiket_adi,etiket_sira,etiket_aktiflik FROM flora_etiket ORDER BY etiket_sira ASC";
        return $this->db->select($sql);
    }

    public function etiketDelete($gelenid) {
        return ($this->db->delete("flora_etiket", "etiket_id=$gelenid"));
    }

    public function etiketSiraUpdate($data, $gelenid) {
        return ($this->db->update("flora_etiket", $data, "etiket_id=$gelenid"));
    }

    public function etiketekle($data) {
        return ($this->db->insert("flora_etiket", $data));
    }

    public function paneletiketupdate($data, $gelenid) {
        return ($this->db->update("flora_etiket", $data, "etiket_id=$gelenid"));
    }

    //home vitrin listeleme
    public function panelvitrinlistele() {
        $sql = "SELECT vitrin_ID,vitrin_baslik,vitrin_aktiflik,vitrin_sira FROM flora_vitrin ORDER BY vitrin_sira ASC";
        return $this->db->select($sql);
    }

    public function vitrinDelete($gelenid) {
        return ($this->db->delete("flora_vitrin", "vitrin_ID=$gelenid"));
    }

    //vitrin değerler listeleme
    public function panelVitrinListe($id) {
        $sql = "SELECT vitrin_ID,vitrin_resimpath,vitrin_baslik,vitrin_yazi,vitrin_url,vitrin_aktiflik,vitrin_sira,vitrin_altbaslik,vitrin_buttonyazi FROM  flora_vitrin WHERE vitrin_ID=$id";
        return $this->db->select($sql);
    }

    public function vitrinSiraUpdate($data, $gelenid) {
        return ($this->db->update("flora_vitrin", $data, "vitrin_ID=$gelenid"));
    }

    public function vitrinekle($data) {
        return ($this->db->insert("flora_vitrin", $data));
    }

    public function vitrinUpdate($data, $gelenid) {
        return ($this->db->update("flora_vitrin", $data, "vitrin_ID=$gelenid"));
    }

    public function panelsabiticerikliste() {
        $sql = "SELECT sbt_id,sbt_uyeliksoz,sbt_hzmtsoz,sbt_gzllksoz,sbt_mesafelistssoz,sbt_tslmatsart,sbt_onbilgilendirmeform,sbt_telefon,sbt_fax,sbt_adres,sbt_haritaiframe,sbt_iletisimmail,sbt_yonetmail2,sbt_yonetmail1,sbt_face,sbt_twit,sbt_instag,sbt_gplus,sbt_logo FROM  flora_sabiticerik";
        return $this->db->select($sql);
    }

    public function panelsabiticerikler() {
        $sql = "SELECT sbt_id FROM  flora_sabiticerik";
        return $this->db->select($sql);
    }

    public function sabiticerikekle($data) {
        return ($this->db->insert("flora_sabiticerik", $data));
    }

    public function sabitIcerikUpdate($data, $gelenid) {
        return ($this->db->update("flora_sabiticerik", $data, "sbt_id=$gelenid"));
    }

    public function panelblogliste() {
        $sql = "SELECT blog_ID,blog_baslik,blog_tarih,blog_aktiflik FROM  flora_blog ORDER BY blog_tarih DESC";
        return $this->db->select($sql);
    }

    public function blogDelete($gelenid) {
        return ($this->db->delete("flora_blog", "blog_ID=$gelenid"));
    }

    public function blogekle($data) {
        return ($this->db->insert("flora_blog", $data));
    }

    public function panelBlogDetayListe($id) {
        $sql = "SELECT blog_ID,blog_baslik,blog_yazi,blog_resim,blog_aktiflik FROM  flora_blog WHERE blog_ID=$id";
        return $this->db->select($sql);
    }

    public function blogUpdate($data, $gelenid) {
        return ($this->db->update("flora_blog", $data, "blog_ID=$gelenid"));
    }

    //admin sayfa listeleme
    public function adminSayfalistele() {
        $sql = "SELECT sabitsayfaid,sayfa_UstID,sbtsayfa_Sira,sbtsayfa_Aktiflik,sbtsayfa_Adi FROM flora_sabitsayfa ORDER BY sbtsayfa_Sira ASC";
        return $this->db->select($sql);
    }

    public function panelSayfaDetayListe($id) {
        $sql = "SELECT sabitsayfaid,sayfa_Resim,sayfa_Yazi FROM  flora_sabitsayfa WHERE sabitsayfaid=$id";
        return $this->db->select($sql);
    }

    public function altSayfaDelete($gelenid) {
        return ($this->db->delete("flora_sabitsayfa", "sabitsayfaid=$gelenid"));
    }

    public function ustAltSayfaDelete($gelenid) {
        return ($this->db->delete("flora_sabitsayfa", "sayfa_UstID=$gelenid"));
    }

    public function sayfaSiraUpdate($data, $gelenid) {
        return ($this->db->update("flora_sabitsayfa", $data, "sabitsayfaid=$gelenid"));
    }

    public function sayfaekle($data) {
        return ($this->db->insert("flora_sabitsayfa", $data));
    }

    public function sayfaUpdate($data, $gelenid) {
        return ($this->db->update("flora_sabitsayfa", $data, "sabitsayfaid=$gelenid"));
    }

    public function kargoListele() {
        $sql = "SELECT kargofirma_id,kargofirma_adi,kargofirma_aktiflik,kargofirma_aciklama FROM flora_kargofirma ORDER BY kargofirma_adi ASC";
        return $this->db->select($sql);
    }

    public function kargoDelete($gelenid) {
        return ($this->db->delete("flora_kargofirma", "kargofirma_id=$gelenid"));
    }

    public function kargoekle($data) {
        return ($this->db->insert("flora_kargofirma", $data));
    }

    public function kargoUpdate($data, $gelenid) {
        return ($this->db->update("flora_kargofirma", $data, "kargofirma_id=$gelenid"));
    }

    public function bankaListele() {
        $sql = "SELECT banka_ID,banka_adi,banka_aktif,banka_sube,banka_hesapno,banka_ibanno,banka_alici FROM flora_banka ORDER BY banka_adi ASC";
        return $this->db->select($sql);
    }

    public function bankaDelete($gelenid) {
        return ($this->db->delete("flora_banka", "banka_ID=$gelenid"));
    }

    public function bankaekle($data) {
        return ($this->db->insert("flora_banka", $data));
    }

    public function bankaUpdate($data, $gelenid) {
        return ($this->db->update("flora_banka", $data, "banka_ID=$gelenid"));
    }

    public function yerListele() {
        $sql = "SELECT gonderimyeri_ID,gonderimyeri_adi,gonderimyeri_aktif FROM flora_gonderimyeri ORDER BY gonderimyeri_adi ASC";
        return $this->db->select($sql);
    }

    public function yerDelete($gelenid) {
        return ($this->db->delete("flora_gonderimyeri", "gonderimyeri_ID=$gelenid"));
    }

    public function yerekle($data) {
        return ($this->db->insert("flora_gonderimyeri", $data));
    }

    public function yerUpdate($data, $gelenid) {
        return ($this->db->update("flora_gonderimyeri", $data, "gonderimyeri_ID=$gelenid"));
    }

    public function nedenListele() {
        $sql = "SELECT gonderimnedeni_ID,gonderimnedeni_adi,gonderimnedeni_aktif FROM flora_gonderimnedeni ORDER BY gonderimnedeni_adi ASC";
        return $this->db->select($sql);
    }

    public function nedenDelete($gelenid) {
        return ($this->db->delete("flora_gonderimnedeni", "gonderimnedeni_ID=$gelenid"));
    }

    public function nedenekle($data) {
        return ($this->db->insert("flora_gonderimnedeni", $data));
    }

    public function nedenUpdate($data, $gelenid) {
        return ($this->db->update("flora_gonderimnedeni", $data, "gonderimnedeni_ID=$gelenid"));
    }

    public function adminIllistele() {
        $sql = "SELECT sehir_id,sehir_adi,sehir_aktiflik FROM  flora_sehir WHERE sehir_id=47 ORDER BY sehir_adi ASC";
        return $this->db->select($sql);
    }

    public function adminIlcelistele() {
        $sql = "SELECT ilce_id,ilce_sehirid,ilce_adi,ilce_aktiflik,ilce_ekucret FROM flora_ilce WHERE ilce_sehirid=47 ORDER BY ilce_adi ASC";
        return $this->db->select($sql);
    }

    public function ilUpdate($data, $gelenid) {
        return ($this->db->update("flora_sehir", $data, "sehir_id=$gelenid"));
    }

    public function ilceUpdate($data, $gelenid) {
        return ($this->db->update("flora_ilce", $data, "ilce_id=$gelenid"));
    }

    public function siparisListele() {
        $sql = "SELECT siparis_ID,siparis_No,siparis_gonderenAdSoyad,siparis_gonderenkur,siparis_girilmetarih,siparis_durum FROM flora_siparis ORDER BY siparis_ID ASC";
        return $this->db->select($sql);
    }

    public function siparisBekleyenListele() {
        $sql = "SELECT siparis_ID,siparis_No,siparis_gonderenAdSoyad,siparis_gonderenkur,siparis_girilmetarih,siparis_durum FROM flora_siparis WHERE siparis_durum=0 ORDER BY siparis_ID ASC";
        return $this->db->select($sql);
    }

    public function siparisDetaylistele($id) {
        $sql = "SELECT * from flora_siparis WHERE siparis_ID=$id";
        return $this->db->select($sql);
    }

    public function siparisUrunDetaylistele($id) {
        $sql = "SELECT siparisurun_ID,siparisurun_siparisID,siparisurun_urunID,siparisurun_ad,siparisurun_kod,siparisurun_miktar,siparisurun_tutar,siparisurun_tip,siparisurun_resim from flora_siparisurun WHERE siparisurun_siparisID=$id";
        return $this->db->select($sql);
    }

    public function siparisUpdate($data, $gelenid) {
        return ($this->db->update("flora_siparis", $data, "siparis_ID=$gelenid"));
    }

    public function sipariskargoListele() {
        $sql = "SELECT kargofirma_id,kargofirma_adi FROM flora_kargofirma WHERE kargofirma_aktiflik=1 ORDER BY kargofirma_adi ASC";
        return $this->db->select($sql);
    }

    public function siparisCountListele() {
        $sql = "SELECT siparis_ID,siparis_durum FROM flora_siparis";
        return $this->db->select($sql);
    }

    //kampanya listeleme
    public function adminkampanyalistele() {
        $sql = "SELECT kampanya_ID,kampanya_baslik,kampanya_aktiflik,kampanya_indirimyuzde FROM flora_kampanya";
        return $this->db->select($sql);
    }

    public function kampanyaDelete($gelenid) {
        return ($this->db->delete("flora_kampanya", "kampanya_ID=$gelenid"));
    }

    public function kampanyaUrunUpdate($data, $gelenid) {
        return ($this->db->update("flora_urun", $data, "urun_kmpnyaid=$gelenid"));
    }

    //vitrin değerler listeleme
    public function panelKampanyaListe($id) {
        $sql = "SELECT kampanya_ID,kampanya_baslik,kampanya_yazi,kampanya_baslamatarih,kampanya_bitistarihi,kampanya_aktiflik,kampanya_indirimyuzde,kampanya_kategori FROM  flora_kampanya WHERE kampanya_ID=$id";
        return $this->db->select($sql);
    }

    public function kampanyUrunUpdate($data, $array = array()) {
        return ($this->db->update("flora_urun", $data, "urun_kategoriID IN ($array)"));
    }

    public function kampanyaUpdate($data, $gelenid) {
        return ($this->db->update("flora_kampanya", $data, "kampanya_ID=$gelenid"));
    }

    public function kurumsalUyeListele() {
        $sql = "SELECT kullanici_id,kullanici_adSoyad,kullanici_eposta,kullanici_tel FROM flora_kullanici WHERE kullanici_rol=2 ORDER BY kullanici_adSoyad ASC";
        return $this->db->select($sql);
    }

    public function kurumsalUyeDetayListe($id) {
        $sql = "SELECT kullanici_id,kullanici_adSoyad,kullanici_eposta,kullanici_kurumadi,kullanici_vergid,kullanici_vergino,kullanici_kurumtel,kullanici_tel,kullanici_adres,kullanici_tarih FROM  flora_kullanici WHERE kullanici_id=$id";
        return $this->db->select($sql);
    }

    public function kurumsalUyeSiparis($id) {
        $sql = "SELECT siparis_No,siparis_girilmetarih,siparis_toplamtutar FROM  flora_siparis WHERE siparis_gonderenID=$id";
        return $this->db->select($sql);
    }

    public function bireyselUyeListele() {
        $sql = "SELECT kullanici_id,kullanici_adSoyad,kullanici_eposta,kullanici_tel FROM flora_kullanici WHERE kullanici_rol=0 ORDER BY kullanici_adSoyad ASC";
        return $this->db->select($sql);
    }

    public function bireyselUyeSiparis($id) {
        $sql = "SELECT siparis_No,siparis_girilmetarih,siparis_toplamtutar FROM  flora_siparis WHERE siparis_gonderenID=$id";
        return $this->db->select($sql);
    }

    public function bireyselUyeDetayListe($id) {
        $sql = "SELECT kullanici_id,kullanici_adSoyad,kullanici_eposta,kullanici_kurumadi,kullanici_vergid,kullanici_vergino,kullanici_kurumtel,kullanici_tel,kullanici_adres,kullanici_tarih FROM  flora_kullanici WHERE kullanici_id=$id";
        error_log($sql);
        return $this->db->select($sql);
    }

}

?>
