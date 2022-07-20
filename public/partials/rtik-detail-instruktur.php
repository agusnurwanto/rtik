<?php 
global $post;
global $wpdb;
$url_profile = get_post_meta($post->ID, '_meta_foto', true);
$nama = get_post_meta($post->ID, '_meta_nama', true);
$jabatan = get_post_meta($post->ID, '_meta_jabatan', true);
$sosmed = get_post_meta($post->ID, '_meta_sosmed', true);
$deskripsi = get_post_meta($post->ID, '_meta_deskripsi', true);
$daftar_instruktur = $this->functions->generatePage(array(
    'nama_page' => 'Daftar Instruktur',
    'content' => '[daftar_instruktur]',
    'show_header' => 1,
    'no_key' => 1,
    'post_status' => 'publish'
));
?>
<!-- https://bbbootstrap.com/snippets/bootstrap-5-user-social-profile-transition-effect-79746232 -->
<style type="text/css">
    h1.entry-title {
        display: none;
    }
</style>
<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card p-3 py-4">
                <div class="text-center">
                    <img src="<?php echo $url_profile; ?>" width="300" class="rounded-circle">
                </div>
                <div class="text-center mt-3">
                    <h5 class="mt-2 mb-0"><?php echo $jabatan; ?></h5>
                    <?php echo $sosmed; ?>
                    <div class="px-4 mt-1">
                        <?php echo $deskripsi; ?>
                    </div>
                    <div class="buttons">
                        <a href="<?php $daftar_instruktur; ?>" class="btn btn-outline-primary px-4">Daftar Instruktur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>