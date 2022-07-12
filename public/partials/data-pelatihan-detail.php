<?php
global $post;
global $wpdb;
$judul = get_post_meta($post->ID, 'meta_judul', true);
$materi = get_post_meta($post->ID, 'meta_materi', true);
$narasumber = get_post_meta($post->ID, 'meta_narasumber', true);
$waktu = get_post_meta($post->ID, 'meta_waktu', true);
$lokasi = get_post_meta($post->ID, 'meta_lokasi', true);
$pamflet = get_post_meta($post->ID, 'meta_pamflet', true);
$deskripsi = get_post_meta($post->ID, 'meta_deskripsi', true);
$peserta_all = $wpdb->get_results('
    select 
        * 
    from rtik_peserta_pelatihan 
    where id_pelatihan='.$post->ID.'
    order by lolos DESC, waktu_daftar ASC, waktu_daftar_ulang ASC', ARRAY_A);
$table_pendaftar = '';
$no = 0;
foreach($peserta_all as $peserta){
    $no++;
    $data_peserta = get_post($peserta['id_peserta']);
    $nama_peserta = get_post_meta($peserta['id_peserta'], 'meta_nama', true);
    $alamat_peserta = get_post_meta($peserta['id_peserta'], 'meta_alamat', true);
    $meta_email = get_post_meta($peserta['id_peserta'], 'meta_email', true);
    $meta_usaha = get_post_meta($peserta['id_peserta'], 'meta_usaha', true);
    // $nama_peserta .= ' | '.$meta_email;
    $terpilih = '';
    if($peserta['lolos'] == 1){
        $terpilih = 'Iya';
    }
    $table_pendaftar .= '
        <tr id="'.$peserta['id'].'" id_peserta="'.$peserta['id_peserta'].'" id_pelatihan="'.$peserta['id_pelatihan'].'">
            <td class="text-center">'.$no.'</td>
            <td class="text-center">'.$peserta['waktu_daftar'].'</td>
            <td>'.$nama_peserta.'</td>
            <td>'.$meta_usaha.'</td>
            <td>'.$alamat_peserta.'</td>
            <td>'.$peserta['harapan'].'</td>
            <td class="text-center">'.$peserta['waktu_daftar_ulang'].'</td>
            <td>'.$peserta['konfirmasi_hadir'].'</td>
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
</style>
<div class="cetak">
    <div style="padding: 10px;">
        <h2 class="text-center"><?php echo $judul; ?></h2>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="width: 150px;">Judul</td>
                    <th><?php echo $judul; ?></th>
                </tr>
                <tr>
                    <td>Materi</td>
                    <td><?php echo $materi; ?></td>
                </tr>
                <tr>
                    <td>Narasumber</td>
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
                <tr>
                    <td colspan="2">
                        <h4 class="text-center">Data Pendaftar Pelatihan</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center" style="width: 100px;">Daftar</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Usaha</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Harapan</th>
                                    <th class="text-center" style="width: 100px;">Daftar Ulang</th>
                                    <th class="text-center">Konfirmasi Hadir</th>
                                    <th class="text-center">Saran</th>
                                    <th class="text-center">Terpilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $table_pendaftar; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>