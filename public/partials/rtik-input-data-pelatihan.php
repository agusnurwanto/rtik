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
                <label for="inputEmail3" class="col-md-2 col-form-label">Judul Pelatihan</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Waktu</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="" value="">
                </div>
                <label class="col-md-2 col-form-label">Lokasi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Materi</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="" value="">
                </div>
                <label class="col-md-2 col-form-label">Narasumber</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="" value="">
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
                    wp_editor('','kronologi',array('textarea_name' => 'pamflet', 'textarea_rows' => 10)); 
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