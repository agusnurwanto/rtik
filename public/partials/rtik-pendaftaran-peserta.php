<?php
$api_key = get_option('_crb_rtik_apikey');
$data_pelatihan = $this->get_pelatihan_aktif();
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
        <h2 class="text-center">Pendaftaran Peserta Pelatihan</h2>
        <form>
            <div class="form-group row">
                <label for="pelatihan" class="col-md-2 col-form-label">Judul Pelatihan</label>
                <div class="col-md-10">
                    <select class="form-control" name="judul-pelatihan"></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Keterangan Pelatihan</label>
                <div class="col-md-4">
                    <div id="detail-pelatihan"></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">ID Peserta Jika Sudah Pernah Mendaftar</label>
                <div class="col-md-10">
                    <select class="form-control" id="id-peserta"></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Email</label>
                <div class="col-md-4 input-group">
                    <input class="form-control text-right" id="email-konfirmasi" type="email"/>
                    <div class="input-group-append">
                        <span class="input-group-text">@gmail.com</span>
                        <a onclick="cari_data(); return false;" href="#" class="btn btn-success" style="display: flex; align-items: center;">Cari Data</a>
                    </div>
                </div>
                <label class="col-md-2 col-form-label">Nama Peserta</label>
                <div class="col-md-4">
                    <input class="form-control" name="nama-peserta" type="text"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nomor WA</label>
                <div class="col-md-4">
                    <input class="form-control" name="nomor-wa" type="number"/>
                </div>
                <label class="col-md-2 col-form-label">Alamat</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="alamat-peserta"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nama Usaha / Produk</label>
                <div class="col-md-4">
                    <input class="form-control" name="usaha" type="text"/>
                </div>
                <label class="col-md-2 col-form-label">Link Website</label>
                <div class="col-md-4">
                    <input class="form-control" name="website" type="text"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Link Akun Sosial Media (Google Busines, Facebook, Instagram, Twitter, Tiktok, Dst).</label>
                <div class="col-md-4">
                    <input class="form-control" name="sosmed" type="text"/>
                </div>
                <label class="col-md-2 col-form-label">Link Akun Marketplace (Shopee, Tokopedia, Bukalapak, Lazada, Dst).</label>
                <div class="col-md-4">
                    <input class="form-control" name="marketplace" type="text"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Pekerjaan</label>
                <div class="col-md-4">
                    <input class="form-control" name="pekerjaan" type="text"/>
                </div>
                <label class="col-md-2 col-form-label">Tanggal Lahir</label>
                <div class="col-md-4">
                    <input class="form-control" name="tanggal_lahir" type="date"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Harapan setelah mengikuti pelatihan</label>
                <div class="col-md-4">
                    <input class="form-control" name="harapan" type="text"/>
                </div>
                <label class="col-md-2 col-form-label">Saran untuk panitia pelaksana</label>
                <div class="col-md-4">
                    <input class="form-control" name="saran" type="text"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Pengalaman yang sudah dimiliki terkait materi pelatihan</label>
                <div class="col-md-4">
                    <input class="form-control" name="pengalaman" type="text"/>
                </div>
                <label class="col-md-2 col-form-label">Apakah anda punya laptop? Jika iya, harap dibawa saat pelatihan</label>
                <div class="col-md-4">
                    <select class="form-control" name="laptop">
                        <option value="Iya">Iya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Apakah bisa hadir di <b><span id="tempat-pelatihan"></span></b> pada <b><span id="waktu-pelatihan"></span></b>?</label>
                <div class="col-md-4">
                    <select class="form-control" name="konfirmasi_hadir">
                        <option value="Bisa hadir">Bisa hadir</option>
                        <option value="Belum bisa hadir">Belum bisa hadir</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Aksi</label>
                <div class="col-md-10">
                    <a onclick="simpan_data(); return false;" href="#" class="btn btn-primary">Simpan</a>
                    <button type="reset" class="btn btn-warning">Kosongkan Form</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo RTIK_PLUGIN_URL.'public/js/select2.min.js'; ?>"></script>
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
                +'<table>'
                    +'<tr>'
                        +'<td>Judul</td>'
                        +'<td>:</td>'
                        +'<td>'+pelatihan[post_id].judul+'</td>'
                    +'</tr>'
                    +'<tr>'
                        +'<td>Materi</td>'
                        +'<td>:</td>'
                        +'<td>'+pelatihan[post_id].materi+'</td>'
                    +'</tr>'
                    +'<tr>'
                        +'<td>Narasumber</td>'
                        +'<td>:</td>'
                        +'<td>'+pelatihan[post_id].narasumber+'</td>'
                    +'</tr>'
                    +'<tr>'
                        +'<td>Waktu</td>'
                        +'<td>:</td>'
                        +'<td>'+pelatihan[post_id].waktu+'</td>'
                    +'</tr>'
                    +'<tr>'
                        +'<td>Lokasi</td>'
                        +'<td>:</td>'
                        +'<td>'+pelatihan[post_id].lokasi+'</td>'
                    +'</tr>'
                    +'<tr>'
                        +'<td>Pamflet</td>'
                        +'<td>:</td>'
                        +'<td>'+pelatihan[post_id].pamflet+'</td>'
                    +'</tr>'
                +'</table>';
            jQuery('#detail-pelatihan').html(data);
            jQuery('#waktu-pelatihan').text(pelatihan[post_id].waktu);
            jQuery('#tempat-pelatihan').text(pelatihan[post_id].lokasi);
        });

        var ajax_peserta = {
            ajax: {
                url: ajax.url,
                type: 'post',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 0,
                        action: 'get_data_peserta',
                        api_key : '<?php echo $api_key; ?>'
                    }
                    return query;
                },
                processResults: function (data, params) {
                    console.log('data', data);
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                }
            },
            placeholder: 'Nama dan Alamat',
            minimumInputLength: 3
        };
        jQuery("#id-peserta").select2(ajax_peserta);
    });

    function simpan_data(){
        var id_pelatihan = jQuery('select[name="judul-pelatihan"]').val();
        if(id_pelatihan == ''){
            return alert('Pilih pelatihan dulu!');
        }
        var email = jQuery('#email-konfirmasi').val();
        if(email == ''){
            return alert('email tidak boleh kosong!')
        }else{
            email += '@gmail.com';
        }
        var nama = jQuery('input[name="nama-peserta"]').val();
        var id_peserta = jQuery('input[name="nama-peserta"]').attr('id_peserta');
        if(nama == ''){
            return alert('nama tidak boleh kosong!')
        }
        var wa = jQuery('input[name="nomor-wa"]').val();
        if(wa == ''){
            return alert('wa tidak boleh kosong!')
        }
        var alamat = jQuery('textarea[name="alamat-peserta"]').val();
        if(alamat == ''){
            return alert('alamat tidak boleh kosong!')
        }
        var usaha = jQuery('input[name="usaha"]').val();
        if(usaha == ''){
            return alert('usaha tidak boleh kosong!')
        }
        var website = jQuery('input[name="website"]').val();
        if(website == ''){
            return alert('website tidak boleh kosong!')
        }
        var sosmed = jQuery('input[name="sosmed"]').val();
        if(sosmed == ''){
            return alert('sosmed tidak boleh kosong!')
        }
        var marketplace = jQuery('input[name="marketplace"]').val();
        if(marketplace == ''){
            return alert('marketplace tidak boleh kosong!')
        }
        var tanggal_lahir = jQuery('input[name="tanggal_lahir"]').val();
        if(tanggal_lahir == ''){
            return alert('tanggal_lahir tidak boleh kosong!')
        }
        var harapan = jQuery('input[name="harapan"]').val();
        if(harapan == ''){
            return alert('harapan tidak boleh kosong!')
        }
        var saran = jQuery('input[name="saran"]').val();
        if(saran == ''){
            return alert('saran tidak boleh kosong!')
        }
        var pengalaman = jQuery('input[name="pengalaman"]').val();
        if(pengalaman == ''){
            return alert('pengalaman tidak boleh kosong!')
        }
        var laptop = jQuery('select[name="laptop"]').val();
        if(laptop == ''){
            return alert('laptop tidak boleh kosong!')
        }
        var konfirmasi_hadir = jQuery('select[name="konfirmasi_hadir"]').val();
        if(konfirmasi_hadir == ''){
            return alert('konfirmasi_hadir tidak boleh kosong!')
        }
        if(confirm("Apakah anda yakin untuk menyimpan data ini?")){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                url: ajax.url,
                type: "post",
                data: {
                    "action": "simpan_peserta_satuan",
                    "api_key": "<?php echo $api_key; ?>",
                    "id_pelatihan": id_pelatihan,
                    "id_peserta": id_peserta,
                    "email": email,
                    "nama": nama,
                    "wa": wa,
                    "alamat": alamat,
                    "usaha": usaha,
                    "website": website,
                    "sosmed": sosmed,
                    "marketplace": marketplace,
                    "tanggal_lahir": tanggal_lahir,
                    "harapan": harapan,
                    "saran": saran,
                    "pengalaman": pengalaman,
                    "laptop": laptop,
                    "konfirmasi_hadir": konfirmasi_hadir
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

    function cari_data(){
        var id_peserta = jQuery('#id-peserta').val();
        var email = jQuery('#email-konfirmasi').val();

        if(id_peserta == ''){
            return alert('ID peserta harus dipilih dulu!');
        }
        if(email == ''){
            return alert('Email peserta tidak boleh kosong!');
        }
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            url: ajax.url,
            type: "post",
            data: {
                "action": "cari_detail_peserta",
                "api_key": "<?php echo $api_key; ?>",
                "id_peserta": id_peserta,
                "email": email+'@gmail.com'
            },
            dataType: "json",
            success: function(data){
                jQuery('#wrap-loading').hide();
                if(data.status == 'success'){
                    jQuery('input[name="nama-peserta"]').attr('id_peserta', data.data.id_peserta);
                    jQuery('input[name="nama-peserta"]').val(data.data.nama);
                    jQuery('input[name="nomor-wa"]').val(data.data.wa);
                    jQuery('textarea[name="alamat-peserta"]').val(data.data.alamat);
                    jQuery('input[name="usaha"]').val(data.data.usaha);
                    jQuery('input[name="website"]').val(data.data.website);
                    jQuery('input[name="sosmed"]').val(data.data.sosmed);
                    jQuery('input[name="marketplace"]').val(data.data.marketplace);
                    jQuery('input[name="tanggal_lahir"]').val(data.data.tanggal_lahir);
                    jQuery('input[name="harapan"]').val(data.data.harapan);
                    jQuery('input[name="saran"]').val(data.data.saran);
                    jQuery('input[name="pengalaman"]').val(data.data.pengalaman);
                    jQuery('select[name="laptop"]').val(data.data.laptop);
                    jQuery('select[name="konfirmasi_hadir"]').val(data.data.konfirmasi_hadir);
                }else{
                    jQuery('input[name="nama-peserta"]').attr('id-peserta', '');
                    alert(data.message);
                }
            },
            error: function(e) {
                console.log(e);
                return alert(data.message);
            }
        });
    }
</script>