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
    // $nama_peserta .= ' | '.$meta_email;
    $terpilih = '';
    if($peserta['lolos'] == 1){
        $terpilih = 'Iya';
    }
    $table_pendaftar .= '
        <tr id="'.$peserta['id'].'" id_peserta="'.$peserta['id_peserta'].'" id_pelatihan="'.$peserta['id_pelatihan'].'">
            <td class="text-center">'.$no.'</td>
            <td>'.$nama_peserta.'</td>
            <td>'.$meta_usaha.'</td>
            <td>'.$meta_website.'</td>
            <td>'.$alamat_peserta.'</td>
            <td>'.$peserta['harapan'].'</td>
            <td>'.$peserta['saran'].'</td>
            <td class="text-center">'.$terpilih.'</td>
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
    <div style="padding: 10px;">
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
        <div style="min-width: 900px; padding: 10px;">
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