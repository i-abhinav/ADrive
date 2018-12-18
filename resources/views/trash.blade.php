@extends('layout.common')
@section('content')
<div id="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ URL::route('home') }}">Home</a>
			</li>
			<li class="breadcrumb-item active">Trash</li>
		</ol>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
			Trash</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th scope="col">Name</th>
								<th scope="col">Last Modified</th>
								<th scope="col">File Size</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($allData as $key => $value)
							@if(!empty($value->trash_folders))
							@foreach($value->trash_folders as $folder)
							<tr>
								<td><i class="fa fa-folder"></i> {{ $folder->name}}</td>
								<td>{{ date("d-M-Y H:i A", strtotime($folder->updated_at)) }}</td>
								<td>--</td>
								<td class="td-actions">
									<a href="{{ URL::route('folder.restore', $folder->folder_uid) }}" rel="tooltip" class="btn btn-primary btn-round btn-just-icon btn-sm" data-original-title="Restore" title="Restore">
										<i class="fa fa-undo"></i>
									</a>
									<a href="{{ URL::route('folder.delete', $folder->folder_uid) }}" rel="tooltip" class="btn btn-danger btn-round btn-just-icon btn-sm delete-confirm" data-original-title="Delete Permanently" title="Delete Permanently">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
							@endforeach
							@endif
							@if(!empty($value->trash_files))
							@foreach($value->trash_files as $file)
							<tr>
								<td data-toggle="tooltip" title="{{$file->original_name}}"><i class="far fa-file"></i> {{ substr($file->original_name, 0, 25)}}</td>
								<td>{{ date("d-M-Y H:i A", strtotime($file->updated_at)) }}</td>
								<td>{{ App\Models\Rules::formatSizeUnits($file->size) }}</td>
								<td class="td-actions">
									<a href="{{ URL::route('file.restore', $file->doc_id) }}" rel="tooltip" class="btn btn-primary btn-round btn-just-icon btn-sm" data-original-title="Restore" title="Restore" target="_blank">
										<i class="fa fa-undo"></i>
									</a>
									<a href="{{ URL::route('file.delete', $file->doc_id) }}" rel="tooltip" class="btn btn-danger btn-round btn-just-icon btn-sm delete-confirm" data-original-title="Delete Permanently" title="Delete Permanently">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
							@endforeach
							@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer small text-muted">Total Items - {{count($allData)}}</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</div>
<!-- /.content-wrapper -->
@stop
@section('script')
@stop