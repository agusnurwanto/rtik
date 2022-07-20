<?php 
global $post;
global $wpdb;
$nama = get_post_meta($post->ID, '_meta_nama', true);
$usaha = get_post_meta($post->ID, '_meta_usaha', true);
$website = get_post_meta($post->ID, '_meta_website', true);
$alamat = get_post_meta($post->ID, '_meta_alamat', true);
$harapan = get_post_meta($post->ID, '_meta_harapan', true);
$daftar_peserta = $this->functions->generatePage(array(
    'nama_page' => 'Daftar Peserta',
    'content' => '[daftar_peserta]',
    'show_header' => 1,
    'no_key' => 1,
    'post_status' => 'publish'
));
?>
<!-- https://bbbootstrap.com/snippets/bootstrap-5-user-social-profile-transition-effect-79746232 -->
<style type="text/css">
    h1.entry-title {
        display: none !important;
    }
</style>
<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card p-3 py-4">
                <div class="text-center mt-3">
                    <h1 class="mt-2 mb-0"><?php echo $nama; ?></h1>
                    <h5><?php echo $usaha; ?></h5>
                    <div style="margin-bottom: 10px;">Website : <?php echo $website; ?></div>
                    <div style="margin-bottom: 10px;">Alamat : <?php echo $alamat; ?></div>
                    <div style="margin-bottom: 25px;" class="px-4 mt-1">
                        Harapan : <?php echo $harapan; ?>
                    </div>
                    <div class="buttons">
                        <a href="<?php echo $daftar_peserta['url']; ?>" class="btn btn-outline-primary px-4">Daftar Peserta Pelatihan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>