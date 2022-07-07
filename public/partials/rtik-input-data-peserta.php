<?php
$api_key = get_option('_crb_rtik_apikey');
$args = array(
    'posts_per_page' => -1,
    'post_type' => 'pelatihan',
    'post_status' => 'publish',
    'meta_query' => array(
       array(
           'key' => 'meta_judul',
           'value' => array(''),
           'compare' => 'NOT IN',
       )
   )
);

$data_pelatihan = array();
$query = new WP_Query($args);
foreach($query->posts as $post){
    $data_pelatihan[$post->ID] = array(
        'title' => get_the_title($post->ID),
        'judul' => get_post_meta($post->ID, 'meta_judul', true),
        'materi' => get_post_meta($post->ID, 'meta_materi', true),
        'narasumber' => get_post_meta($post->ID, 'meta_narasumber', true),
        'waktu' => get_post_meta($post->ID, 'meta_waktu', true),
        'lokasi' => get_post_meta($post->ID, 'meta_lokasi', true),
        'pamflet' => get_post_meta($post->ID, 'meta_pamflet', true),
        'deskripsi' => get_post_meta($post->ID, 'meta_deskripsi', true)
    );
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
        <h2 class="text-center">Input data peserta pelatihan</h2>
        <form>
            <div class="form-group row">
                <label for="pelatihan" class="col-md-2 col-form-label">Judul Pelatihan</label>
                <div class="col-md-4">
                    <select class="form-control" name="judul-pelatihan"></select>
                </div>
                <label class="col-md-2 col-form-label">Keterangan Pelatihan</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="detail-pelatihan" disabled></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Import Excel</label>
                <div class="col-md-4">
                    <input type="file" class="form-control" name="" value="" onchange="filePicked(event);">
                </div>
                <label class="col-md-2 col-form-label">Data JSON</label>
                <div class="col-md-4">
                    <textarea class="form-control" id="data-excel" name="data-excel" style="min-height: 100px;"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_data(); return false;" href="#" class="btn btn-primary">Simpan</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo RTIK_PLUGIN_URL.'public/js/jszip.js'; ?>"></script>
<script type="text/javascript" src="<?php echo RTIK_PLUGIN_URL.'public/js/xlsx.js'; ?>"></script>
<script type="text/javascript">
    window.pelatihan = <?php echo json_encode($data_pelatihan); ?>;
    var pilih_pelatihan = '<option value="">Pilih Pelatihan</option>';
    for (var i in pelatihan){
        pilih_pelatihan += '<option value="'+i+'">'+pelatihan[i].title+'</option>';
    };
    jQuery(document).ready(function(){
        jQuery('select[name="judul-pelatihan"]').html(pilih_pelatihan);
        jQuery('select[name="judul-pelatihan"]').on('change', function(){
            var post_id = jQuery(this).val();
            var data = ''
                +'Judul: '+pelatihan[post_id].judul+'\n'
                +'Materi: '+pelatihan[post_id].materi+'\n'
                +'Narasumber: '+pelatihan[post_id].narasumber+'\n'
                +'Waktu: '+pelatihan[post_id].waktu+'\n'
                +'Lokasi: '+pelatihan[post_id].lokasi+'\n';
            jQuery('textarea[name="detail-pelatihan"]').val(data);
        });
    });

    function simpan_data(){
        var id_pelatihan = jQuery('select[name="judul-pelatihan"]').val();
        if(id_pelatihan == ''){
            return alert('Pilih pelatihan dulu!');
        }
        var data_excel = jQuery('#data-excel').val();
        if(data_excel == ''){
            return alert('Pilih file excel dulu!');
        }
        if(confirm("Apakah anda yakin untuk menyimpan data ini?")){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "simpan_peserta",
                    "api_key": "<?php echo $api_key; ?>",
                    "data_excel": data_excel,
                    "id_pelatihan": id_pelatihan,
                },
                dataType: "json",
                success: function(data){
                    jQuery('#wrap-loading').hide();
                    alert(data.message);
                    if(data.status == 'success'){
                        // window.location = location.href;
                    }
                },
                error: function(e) {
                    console.log(e);
                    return alert(data.message);
                }
            });
        }
    }
</script>