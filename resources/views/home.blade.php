@extends('layouts.master')

@section('content')
<script src="plugins/jquery/jquery-3.4.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="plugins/fancybox/jquery.fancybox.min.css">
<script src="plugins/fancybox/jquery.fancybox.min.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="margin-left: 20%; height: 100%; width: 100%;">
					<div class="box box-danger">
						<div class="box-header with-border">
						  <h3 class="box-title">Interogările de testare</h3>
						</div>
						<div class="box-body">
						  <div class="row">
							<div class="col-xs-4">
							<a type="button" href="{{URL('/original_q1_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q1</a>
							  
							</div>
							<div class="col-xs-4">
								<a type="button" href="{{URL('/original_q3_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q3</a>
							</div>
							<div class="col-xs-4">
								<a type="button" href="{{URL('/original_q4_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q4</a>
							</div>
						  </div>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					<div id="main-img" style="margin-left: 20%; height: 100%; width: 100%;">
						<img src="{{URL('/images/tpch.png')}}" width="100%" height="100%" alt="lorem">
					</div>
                  
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$('.fancybox-form').fancybox({
	width: 800,
	height: 800,
	touch: false,
	autoSize: false,
	href: 'http://masternew/public/original_q1_form',
	type: 'ajax'
});

/*$(".box-body").fancybox({
	'showCloseButton'	: false,
	'titlePosition' 		: 'inside',
});*/
</script>
@endsection