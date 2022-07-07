<?php
    $api_key = get_option('_crb_rtik_apikey');
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
        <h2 class="text-center">Input data pelatihan</h2>
        <form>
            <div class="form-group row">
                <label for="judul" class="col-md-2 col-form-label">Judul Pelatihan</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="judul" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Materi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="materi" value="">
                </div>
                <label class="col-md-2 col-form-label">Narasumber</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="narasumber" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Waktu</label>
                <div class="col-md-4">
                    <input type="datetime-local" class="form-control" name="waktu" value="">
                </div>
                <label class="col-md-2 col-form-label">Lokasi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="lokasi" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Deskripsi Pelatihan</label>
                <div class="col-md-10">
                <?php
                    wp_editor('','deskripsi',array('textarea_name' => 'deskripsi', 'textarea_rows' => 10)); 
                ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Pamflet / Poster</label>
                <div class="col-md-10">
                <?php
                    wp_editor('','pamflet',array('textarea_name' => 'pamflet', 'textarea_rows' => 10)); 
                ?>
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
<script type="text/javascript">
function simpan_data(){
    if(confirm("Apakah anda yakin untuk menyimpan data ini?")){
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            url: ajax.url,
            type: "post",
            data: {
                "action": "simpan_pelatihan",
                "api_key": "<?php echo $api_key; ?>",
                "judul": jQuery('input[name="judul"]').val(),
                "materi": jQuery('input[name="materi"]').val(),
                "narasumber": jQuery('input[name="narasumber"]').val(),
                "waktu": jQuery('input[name="waktu"]').val(),
                "lokasi": jQuery('input[name="lokasi"]').val(),
                "pamflet": tinyMCE.get('pamflet').getContent(),
                "deskripsi": tinyMCE.get('deskripsi').getContent()
            },
            dataType: "json",
            success: function(data){
                jQuery('#wrap-loading').hide();
                alert(data.message);
                if(data.status == 'success'){
                    window.location = location.href;
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