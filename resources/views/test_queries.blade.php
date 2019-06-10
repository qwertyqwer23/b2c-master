@extends('layouts.master')

@section('content')
<script src="plugins/jquery/jquery-3.4.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="plugins/fancybox/jquery.fancybox.min.css">
<script src="plugins/fancybox/jquery.fancybox.min.js"></script>

<section class="content">
   <div class="row">
        <div class="col-xs-12">
			<div class="box box-danger collapsed-box">
				<div class="box-header with-border">
				  <h3 class="box-title">MongoDB</h3>

				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div>
				<div class="box-body" style="display: none;">
				  <div class="row">
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/original_q1_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q1</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
						<a href="{{URL('/original_q1_form')}}" class="btn btn-block btn-default btn-lg fancybox-form "><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/original_q3_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q3</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
					  <a type="button" href="{{URL('/original_q3_form')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
						<a type="button" href="{{URL('/original_q4_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q4</a>
					</div>
					<div class="col-xs-2">
					 <a type="button" href="{{URL('/original_q4_form')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
				  </div>
				</div>
				<!-- /.box-body -->
			  </div>
        </div>
      </div>
	     <div class="row">
        <div class="col-xs-12">
			<div class="box box-danger collapsed-box">
				<div class="box-header with-border">
				  <h3 class="box-title">Cassandra</h3>

				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div>
				<div class="box-body" style="display: none;">
				  <div class="row">
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/original_q1_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q1</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
						<a href="{{URL('/original_q1_form')}}" class="btn btn-block btn-default btn-lg fancybox-form "><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/original_q3_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q3</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
					  <a type="button" href="{{URL('/original_q3_form')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
						<a type="button" href="{{URL('/original_q4_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q4</a>
					</div>
					<div class="col-xs-2">
					 <a type="button" href="{{URL('/original_q4_form')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
				  </div>
				</div>
				<!-- /.box-body -->
			  </div>
        </div>
      </div>
	     <div class="row">
        <div class="col-xs-12">
			<div class="box box-danger collapsed-box">
				<div class="box-header with-border">
				  <h3 class="box-title">Neo4j</h3>

				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div>
				<div class="box-body" style="display: none;">
				  <div class="row">
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/original_q1_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q1</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
						<a href="{{URL('/original_q1_form')}}" class="btn btn-block btn-default btn-lg fancybox-form "><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/original_q3_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q3</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
					  <a type="button" href="{{URL('/original_q3_form')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
						<a type="button" href="{{URL('/original_q4_form')}}" class="btn btn-block btn-default btn-lg fancybox-form">Q4</a>
					</div>
					<div class="col-xs-2">
					 <a type="button" href="{{URL('/original_q4_form')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
				  </div>
				</div>
				<!-- /.box-body -->
			  </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Responsive Hover Table</h3>

              <div class="box-tools">
			   <div class="box-tools">
                <ul class="pagination pagination-sm no-margin pull-right">
                  <li><a href="#">«</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">»</a></li>
                </ul>
              </div>
               
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Reason</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
                <tr>
                  <td>219</td>
                  <td>Alexander Pierce</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
                <tr>
                  <td>657</td>
                  <td>Bob Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-primary">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
                <tr>
                  <td>175</td>
                  <td>Mike Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-danger">Denied</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>

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