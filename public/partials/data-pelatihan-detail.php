<?php
global $post;
global $wpdb;
$judul = get_post_meta($post->ID, '_meta_judul', true);
$materi = get_post_meta($post->ID, '_meta_materi', true);
$narasumber = get_post_meta($post->ID, '_meta_narasumber', true);
$waktu = get_post_meta($post->ID, '_meta_waktu', true);
$lokasi = get_post_meta($post->ID, '_meta_lokasi', true);
$pamflet = get_post_meta($post->ID, '_meta_pamflet', true);
$deskripsi = get_post_meta($post->ID, '_meta_deskripsi', true);
$daftar_pelatihan = $this->functions->generatePage(array(
    'nama_page' => 'Daftar Pelatihan',
    'content' => '[daftar_pelatihan]',
    'show_header' => 1,
    'no_key' => 1,
    'post_status' => 'publish'
));
$edit_data = false;
$kolom_edit = '';
$kolom_style = 'min-width: 900px;';
if(is_user_logged_in()){
    $user_id = get_current_user_id();
    if($this->functions->user_has_role($user_id, 'administrator')){
        $edit_data = true;
        $kolom_style = 'min-width: 2500px;';
        $kolom_edit = '
            <th class="text-center">Laptop</th>
            <th class="text-center" style="width: 250px;">Email</th>
            <th class="text-center" style="width: 150px;">WA</th>
            <th class="text-center">Sosial Media</th>
            <th class="text-center">Akun Marketplace</th>
            <th class="text-center">Pekerjaan</th>
            <th class="text-center">Tanggal Lahir</th>
            <th class="text-center">Konfirmasi Hadir</th>
        ';
    }
}
$peserta_all = $wpdb->get_results('
    select 
        * 
    from rtik_peserta_pelatihan 
    where id_pelatihan='.$post->ID.'
    order by lolos DESC, waktu_daftar_ulang ASC, waktu_daftar ASC', ARRAY_A);
$table_pendaftar = '';
$no = 0;
foreach($peserta_all as $peserta){
    $no++;
    $data_peserta = get_post($peserta['id_peserta']);
    $nama_peserta = get_post_meta($peserta['id_peserta'], '_meta_nama', true);
    $alamat_peserta = get_post_meta($peserta['id_peserta'], '_meta_alamat', true);
    $meta_email = get_post_meta($peserta['id_peserta'], '_meta_email', true);
    $meta_usaha = get_post_meta($peserta['id_peserta'], '_meta_usaha', true);
    $meta_website = get_post_meta($peserta['id_peserta'], '_meta_website', true);
    $meta_sosmed = get_post_meta($peserta['id_peserta'], '_meta_sosmed', true);
    $meta_marketplace = get_post_meta($peserta['id_peserta'], '_meta_marketplace', true);
    // $nama_peserta .= ' | '.$meta_email;
    $terpilih = '';
    if($peserta['lolos'] == 1){
        $terpilih = 'Iya';
    }
    $data_edit = '';
    if($edit_data){
        $meta_wa = get_post_meta($peserta['id_peserta'], '_meta_wa', true);
        $meta_laptop = get_post_meta($peserta['id_peserta'], '_meta_laptop', true);
        $meta_pekerjaan = get_post_meta($peserta['id_peserta'], '_meta_pekerjaan', true);
        $meta_tanggal_lahir = get_post_meta($peserta['id_peserta'], '_meta_tanggal_lahir', true);
        $meta_konfirmasi_hadir = get_post_meta($peserta['id_peserta'], '_meta_konfirmasi_hadir', true);
        $data_edit = '
            <td>'.$meta_laptop.'</td>
            <td>'.$meta_email.'</td>
            <td>'.$meta_wa.'</td>
            <td>'.$meta_sosmed.'</td>
            <td>'.$meta_marketplace.'</td>
            <td>'.$meta_pekerjaan.'</td>
            <td>'.$meta_tanggal_lahir.'</td>
            <td>'.$meta_konfirmasi_hadir.'</td>
        ';
    }
    $table_pendaftar .= '
        <tr id="'.$peserta['id'].'" id_peserta="'.$peserta['id_peserta'].'" id_pelatihan="'.$peserta['id_pelatihan'].'">
            <td class="text-center">'.$no.'</td>
            <td>'.$nama_peserta.'</td>
            <td>'.$meta_usaha.'</td>
            <td>
                Website: '.$meta_website.'
                <br>Sosmed: '.$meta_sosmed.'
                <br>Marketplace: '.$meta_marketplace.'
            </td>
            <td>'.$alamat_peserta.'</td>
            <td>'.$peserta['harapan'].'</td>
            <td>'.$peserta['saran'].'</td>
            <td class="text-center">'.$terpilih.'</td>
            '.$data_edit.'
        </tr>';
}
?>
<style type="text/css">
    .warning {
        background: #f1a4a4;
    }
    .hide, nav.post-navigation, header.entry-header {
        display: none;
    }
    td {
        word-break: break-word;
    }
</style>
<div class="cetak">
    <div style="padding: 10px; overflow: auto;">
        <h2 class="text-center"><?php echo $judul; ?></h2>
        <div style="min-width: 900px; padding: 10px;">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 100px;">Judul</td>
                        <th><?php echo $judul; ?></th>
                    </tr>
                    <tr>
                        <td>Materi</td>
                        <td><?php echo $materi; ?></td>
                    </tr>
                    <tr>
                        <td>Instruktur</td>
                        <td><?php echo $narasumber; ?></td>
                    </tr>
                    <tr>
                        <td>Waktu</td>
                        <td><?php echo $waktu; ?></td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td><?php echo $lokasi; ?></td>
                    </tr>
                    <tr>
                        <td>Pamflet</td>
                        <td><?php echo $pamflet; ?></td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td><?php echo $deskripsi; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h4 class="text-center">Data Pendaftar Pelatihan</h4>
        <div style="padding: 10px; <?php echo $kolom_style; ?>">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 45px;">No</th>
                        <th class="text-center" style="width: 145px;">Nama</th>
                        <th class="text-center">Usaha</th>
                        <th class="text-center">Website</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Harapan</th>
                        <th class="text-center">Saran</th>
                        <th class="text-center" style="width: 85px;">Terpilih</th>
                    <?php echo $kolom_edit; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $table_pendaftar; ?>
                </tbody>
            </table>
        </div>
        <div class="buttons text-center">
            <a href="<?php echo $daftar_pelatihan['url']; ?>" class="btn btn-outline-primary px-4">Daftar Pelatihan</a>
        </div>
    </div>
</div>