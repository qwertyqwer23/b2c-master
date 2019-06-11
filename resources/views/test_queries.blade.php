@extends('layouts.master')

@section('content')
<script src="plugins/jquery/jquery-3.4.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="plugins/fancybox/jquery.fancybox.min.css">
<script src="plugins/fancybox/jquery.fancybox.min.js"></script>

<meta name="_token" content="{{ csrf_token() }}"/>

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
					  <a type="button" href="{{URL('/mongo_q1_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q1</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
						<a href="{{URL('/mongo_q1_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form "><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/mongo_q3_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q3</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
					  <a type="button" href="{{URL('/mongo_q3_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
						<a type="button" href="{{URL('/mongo_q4_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q4</a>
					</div>
					<div class="col-xs-2">
					 <a type="button" href="{{URL('/mongo_q4_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
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
					  <a type="button" href="{{URL('/neo4j_q1_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q1</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
						<a href="{{URL('/neo4j_q1_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/neo4j_q3_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q3</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
					  <a type="button" href="{{URL('/neo4j_q3_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
						<a type="button" href="{{URL('/neo4j_q4_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q4</a>
					</div>
					<div class="col-xs-2">
					 <a type="button" href="{{URL('/neo4j_q4_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
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
					  <a type="button" href="{{URL('/cassandra_q1_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q1</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
						<a href="{{URL('/cassandra_q1_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form "><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
					  <a type="button" href="{{URL('/cassandra_q3_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q3</a>
					</div>
					<div class="col-xs-2" style="border-right: 5px solid black;">
					  <a type="button" href="{{URL('/cassandra_q3_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
					</div>
					<div class="col-xs-2">
						<a type="button" href="{{URL('/cassandra_q4_statistic')}}" class="btn btn-block btn-default btn-lg ajax-statistic">Q4</a>
					</div>
					<div class="col-xs-2">
					 <a type="button" href="{{URL('/cassandra_q4_code_view')}}" class="btn btn-block btn-default btn-lg fancybox-form"><i class="fa fa-code"></i></a>
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

             
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tbody id="table_body">
				
					</tbody>
				</table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
 {{ csrf_field() }}
<script>

$('.fancybox-form').fancybox({
	width: 800,
	height: 800,
	touch: false,
	autoSize: false,
	//href: 'http://masternew/public/original_q1_form',
	type: 'ajax'
});

	function prepare_values(data)
	{
		var columns_str = '<tr>';
	
		$.each(data, function(index, value) {
			columns_str += '<td>' + value + '</td>'
			
		});
		
		columns_str += '</tr>';
		
		return columns_str;
	}
	
	function prepare_columns(data)
	{
		var columns_str = '<tr>';
		
		Object.keys(data).forEach(function(key) {

			columns_str += '<th>' + key + '</th>'

		});

		columns_str += '</tr>';

		return columns_str;
	}
	
	
	
	function do_columns_arr(data){
		//console.log(data);
		var columns = []
		$.each(data, function(index, value) {
			columns[index] = index;
		});
		
		return columns;
	}

	function drow_table(data){
		
		var result = data.result;
		var columns = [];
		var columns_str = '';
		var values_str = '';
		
		$.each(result, function(index, value) {
			columns = do_columns_arr(value);
			values_str += prepare_values(value);

		});
		
		columns_str = prepare_columns(columns);
		
		
		final_data = '<tbody id="table_body">' + columns_str + values_str + '</tbody>';
		
		$('#table_body').replaceWith(final_data);
		
	}

$(document).on("click", ".ajax-statistic", function(e) {
	e.preventDefault();

	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
	
	$.ajax({
	  type: 'POST',
	  url: $(this).attr('href'),
	 // data: 'name=Andrew&nickname=Aramis',
	  success: function(data){
		  
		  console.log(data)
		  
		  drow_table(data);
		//var result = data.result.q1;
		
		  //$('#table_body').append()
		 // console.log(data)
		//$('.results').html(data);
	  }
	});


 });




/*$(".box-body").fancybox({
	'showCloseButton'	: false,
	'titlePosition' 		: 'inside',
});*/
</script>
@endsection