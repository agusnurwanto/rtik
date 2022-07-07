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
                <label for="inputEmail3" class="col-md-2 col-form-label">Judul Pelatihan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="" value="">
                </div>
                <label class="col-md-2 col-form-label">Keterangan Pelatihan</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="" disabled></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Import Excel</label>
                <div class="col-md-4">
                    <input type="file" class="form-control" name="" value="">
                </div>
                <label class="col-md-2 col-form-label">Data JSON</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="" style="min-height: 100px;"></textarea>
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