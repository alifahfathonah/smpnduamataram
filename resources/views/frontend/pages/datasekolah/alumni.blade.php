@extends('frontend.pages.main')

@section('subcontent')
<!--Start about area-->
<section class="about-area">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="about-text">
                    <div class="sec-title">
                        <div class="title">DAFTAR NAMA ALUMNI<br><span>SMPN 2 Mataram</span></div>
                    </div>
                    <div class="inner-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="additional-info-content-box">
                                    <div class="accordion-box">
                                        @foreach ($data as $row)
                                        <!--Start single accordion box-->
                                        <div class="accordion accordion-block">
                                            <div class="accord-btn active">
                                                <h4>{{ $row->alumni_keterangan }}</h4>
                                            </div>
                                            <div class="accord-content">
                                                <iframe height="500" width="100%" src="{{ $row->alumni_file }}"></iframe>
                                            </div>
                                        </div>
                                        <!--End single accordion box-->
                                        @endforeach

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!--End about Area-->
@endsection
