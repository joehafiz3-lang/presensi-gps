@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal {
        max-height: 430px !important;
    }

    .datepicker-date-display {
        background-color: #409eff !important;
    }

    #keterangan {
        height: 5rem !important;
    }
</style>
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin Sakit</div>
    <div class="right"></div>
</div>
<!-- App Header -->
@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <form method="POST" action="/izinsakit/store" id="frmizin" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" id="tgl_izin_dari" name="tgl_izin_dari" autocomplete="off" class="form-control datepicker" placeholder="Dari">
            </div>
            <!-- Perbaikan di bawah ini: pastikan ada tanda < sebelum div -->
            <div class="form-group">
                <input type="text" id="tgl_izin_sampai" name="tgl_izin_sampai" autocomplete="off" class="form-control datepicker" placeholder="Sampai">
            </div>
            <div class="form-group">
                <input type="text" id="jml_hari" name="jml_hari" class="form-control" autocomplete="off" placeholder="Jumlah Hari" readonly>
            </div>
            <div class="custom-file-upload" id="fileUpload1" style="height: 100px !important">
                <input type="file" name="sid" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                <label for="fileuploadInput">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                aria-label="cloud upload outline"></ion-icon>
                            <i>Tap to Upload SID</i>
                        </strong>
                    </span>
                </label>
            </div>
            <div class="form-group">
                <input type="text" id="keterangan" name="keterangan" class="form-control" autocomplete="off" placeholder="Keterangan">
            </div>


            <div class="form-group">
                <button class="btn btn-primary w-100">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"
        });



        function loadjumlahhari() {
            var dari = $("#tgl_izin_dari").val();
            var sampai = $("#tgl_izin_sampai").val();
            var date1 = new Date(dari);
            var date2 = new Date(sampai);

            // To calculate the time difference of two dates
            var Difference_In_Time = date2.getTime() - date1.getTime();

            // To calculate the no. of days between two dates
            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

            if (dari == "" || sampai == "") {
                var jmlhari = 0;
            } else {
                var jmlhari = Difference_In_Days + 1;
            }


            //To display the final no. of days (result)
            $("#jml_hari").val(jmlhari + " Hari");
        }

        $("#tgl_izin_dari, #tgl_izin_sampai").change(function(e) {
            loadjumlahhari();
        });


        $("#frmizin").submit(function() {
            var tgl_izin_dari = $("#tgl_izin_dari").val();
            var tgl_izin_sampai = $("#tgl_izin_sampai").val();
            var keterangan = $("#keterangan").val();

            if (tgl_izin_dari == "" || tgl_izin_sampai == "") {
                Swal.fire({
                    title: 'Oops !',
                    text: 'Tanggal Harus Diisi',
                    icon: 'warning'
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    title: 'Oops !',
                    text: 'Keterangan Harus Diisi',
                    icon: 'warning'
                });
                return false;
            }
        }); // Menutup $("#frmizin").submit

    }); // MEMPERBAIKI INI: Pastikan hanya tertulis }); untuk menutup $(document).ready
</script>
@endpush