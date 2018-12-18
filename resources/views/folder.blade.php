@extends('layout.common2')
@section('content')
<div id="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ URL::route('home') }}">Home</a>
			</li>
			<li class="breadcrumb-item active">{{ $source->name }}</li>
		</ol>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
			My Drive</div>
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
							@foreach($folderData as $key => $value)
							@if(!empty($value->folders))
							@php $folderCount = count($value->folders); @endphp
							@foreach($value->folders as $folder)
							<tr>
								<td><i class="fa fa-folder"></i> {{ $folder->name}}</td>
								<td>{{ date("d-M-Y H:i A", strtotime($folder->updated_at)) }}</td>
								<td>--</td>
								<td class="td-actions">
									<a href="{{ URL::route('folder.open', $folder->folder_uid) }}" rel="tooltip" class="btn btn-info btn-round btn-just-icon btn-sm" data-original-title="Open" title="Open">
										<i class="fa fa-folder-open"></i>
									</a>
									<a href="{{ URL::route('folder.trash', $folder->folder_uid) }}" rel="tooltip" class="btn btn-danger btn-round btn-just-icon btn-sm delete-confirm" data-original-title="Remove" title="Remove">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
							@endforeach
							@endif
							@if(!empty($value->files))
							@php $fileCount = count($value->files); @endphp
							@foreach($value->files as $file)
							<tr>
								<td data-toggle="tooltip" title="{{$file->original_name}}"><i class="far fa-file"></i> {{ substr($file->original_name, 0, 25)}}</td>
								<td>{{ date("d-M-Y H:i A", strtotime($file->updated_at)) }}</td>
								<td>{{ App\Models\Rules::formatSizeUnits($file->size) }}</td>
								<td class="td-actions">
									<a href="{{ URL::route('file.view', $file->doc_id) }}" rel="tooltip" class="btn btn-info btn-round btn-just-icon btn-sm" data-original-title="Open" title="Open" target="_blank">
										<i class="fa fa-external-link-square-alt"></i>
									</a>
									<a href="{{ URL::route('file.download', $file->doc_id) }}" rel="tooltip" class="btn btn-success btn-round btn-just-icon btn-sm" data-original-title="Remove" title="Download" target="_blank">
										<i class="fa fa-download"></i>
									</a>
									<a href="{{ URL::route('file.trash', $file->doc_id) }}" rel="tooltip" class="btn btn-danger btn-round btn-just-icon btn-sm delete-confirm" data-original-title="Remove" title="Remove">
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
			<div class="card-footer small text-muted">Total Items - {{@$folderCount + @$fileCount}}</div>
		</div>
		<p class="small text-center text-muted my-5">
			{{-- <em>More table examples coming soon...</em> --}}
		</p>
	</div>
	<!-- /.container-fluid -->
	<!-- Sticky Footer -->
	<footer class="sticky-footer">
		<div class="container my-auto">
			<div class="copyright text-center my-auto">
				{{-- <span>lorem</span> --}}
			</div>
		</div>
	</footer>
</div>
<!-- /.content-wrapper -->
@stop
@section('script')
@stop