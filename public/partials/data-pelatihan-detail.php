<?php
global $post;
$judul = get_post_meta($post->ID, 'meta_judul', true);
$materi = get_post_meta($post->ID, 'meta_materi', true);
$narasumber = get_post_meta($post->ID, 'meta_narasumber', true);
$waktu = get_post_meta($post->ID, 'meta_waktu', true);
$lokasi = get_post_meta($post->ID, 'meta_lokasi', true);
$pamflet = get_post_meta($post->ID, 'meta_pamflet', true);
$deskripsi = get_post_meta($post->ID, 'meta_deskripsi', true);
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
        <h2 class="text-center">Data detail pelatihan</h2>
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
            </tbody>
        </table>
    </div>
</div>