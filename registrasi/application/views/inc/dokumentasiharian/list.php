<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>

    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
            <?php $this->load->view('layout/navigation') ?>     

            <!-- =============== Horizontal bar End ================-->
            <div class="main-content-wrap d-flex flex-column">
                <?php $this->load->view('layout/header') ?>
                <!-- ============ Body content start ============= -->
                <div class="main-content">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="#">Absensi</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
<!--                                <div class="card-header">-->
<!--                                    <p class="card-title mb-0">Filter</p>-->
<!--                                </div>-->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php echo form_open_multipart($controller); ?>
                                            <table style="width: 100%;padding: 10px 10px;">
                                                <colgroup>
                                                    <col style="width: 20%">
                                                    <col style="width: 80%">
                                                </colgroup>
                                                <tr>
                                                    <td>
                                                        <label>Tahun</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="tahun" name="tahun" required onchange="getDataTanggal(this)">
                                                            <?php foreach ($tahun as $key => $value) { ?>
                                                                <option value="<?= $value->tahun ?>" <?= $tahun_selected == $value->tahun ? 'selected' : '' ?>><?= $value->tahun ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Tanggal</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="id_rincianjadwal_mingguan" name="id_rincianjadwal_mingguan" required onchange="getDataKelas(this)">
                                                            <?php foreach ($tanggal as $key => $value) { ?>
                                                                <option value="<?= $value->id_rincianjadwal_mingguan ?>" <?= $id_rincianjadwal_mingguan == $value->id_rincianjadwal_mingguan ? 'selected' : '' ?>><?= 'Tema: '.$value->nama_tema.', '.format_date_indonesia($value->tanggal).' '.date('d-m-Y', strtotime($value->tanggal)).' ('.$value->nama_subtema.')' ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Kelas</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="id_jadwalharian" name="id_jadwalharian" required>
                                                            <?php foreach ($kelas as $key => $value) { ?>
                                                                <option value="<?= $value->id_jadwalharian ?>" <?= $id_jadwalharian == $value->id_jadwalharian ? 'selected' : '' ?>><?= $value->nama_kelas ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" >
                                                        <button class="btn btn-sm btn-primary mt-4">Tampilkan</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        <hr>
                                        <div class="table-responsive">
                                            <h5><b>Data Dokumentasi</b></h5>
                                            <div class="file-loading">
                                                <input id="file_dukung" name="file_dukung[]" type="file" accept="image/*" multiple>
                                            </div>
                                        </div>
                                        <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Dokumentasi Harian Anak per Kelas per Hari.</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <?php $this->load->view('layout/file_upload') ?>

    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        var url = "<?= base_url().$controller ?>";
        let initialPreview = <?= json_encode($dokumentasi_file['preview'])?>;
        let initialPreviewConfig = <?= json_encode($dokumentasi_file['config'])?>;
        let id_jadwalharian = <?= $id_jadwalharian ?>;

        $(document).ready(function() {
            let file_input = $('#file_dukung'), initPlugin = function () {
                file_input.fileinput({
                    uploadUrl: url + '/uploadfile',
                    minFileCount: 1,
                    maxFileCount: 5,
                    required: true,
                    showRemove: false,
                    showUpload: false,
                    allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                    previewFileType: 'image',
                    overwriteInitial: false,
                    initialPreview: initialPreview,
                    initialPreviewConfig: initialPreviewConfig,
                    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                    initialPreviewFileType: 'image', // image is the default and can be overridden in config below
                    uploadExtraData: function () {
                        return {'id_jadwalharian': id_jadwalharian};
                    }
                });
            };

            initPlugin();
        });

        function getDataTanggal(dom){
            let tahun = $(dom).val();
            resetInput();

            $.ajax({
                url: url+'/getDataTanggal',
                type: 'POST',
                data: {tahun: tahun},
                success: function(data){
                    let data_tanggal = data['tanggal'];
                    let data_kelas = data['kelas'];

                    $.each(data_tanggal, function(key, value){
                        $('#id_rincianjadwal_mingguan').append('<option value="'+value.id_rincianjadwal_mingguan+'">Tema: '+value.nama_tema+', '+ value.nama_hari + ' ' +value.tanggal+' ('+value.nama_subtema+')</option>');
                    });

                    $.each(data_kelas, function(key, value){
                        $('#id_jadwalharian').append('<option value="'+value.id_jadwalharian+'">'+value.nama_kelas+'</option>');
                    });
                }
            });
        }

        function getDataKelas(dom){
            let id_rincianjadwal_mingguan = $(dom).val();
            $('#id_jadwalharian').html('');

            $.ajax({
                url: url+'/getDataKelas',
                type: 'POST',
                data: {id_rincianjadwal_mingguan: id_rincianjadwal_mingguan},
                success: function(data){
                    let data_kelas = data['kelas'];

                    $.each(data_kelas, function(key, value){
                        $('#id_jadwalharian').append('<option value="'+value.id_jadwalharian+'">'+value.nama_kelas+'</option>');
                    });
                }
            });
        }
    </script>
</html>