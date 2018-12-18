<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ADrive</title>
        <!-- Bootstrap core CSS-->
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <!-- Custom styles for this template-->
        <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
        @yield('css')
        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Core plugin JavaScript-->
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset("/js/ajax-form.jquery.js")}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{ asset("/js/main.js")}}"></script>
    </head>
    <!-- END HEAD -->
    <body id="page-top">
        <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
            <a class="navbar-brand mr-1" href="{{ URL::route('home') }}">ADrive</a>
            <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
            </button>
            <!-- Navbar Search -->
            {{-- <form class="d-md-inline-block form-inline col-centered my-2 my-md-0 col-md-6"> --}}
                {!! Form::open(['route' => 'search', 'method'=> 'POST', 'id' => 'search-form', 'class'=>'d-md-inline-block form-inline col-centered my-2 my-md-0 col-md-6']) !!}
                <div class="input-group">
                    <input type="text" name="search_key" class="form-control" placeholder="Search files and folders..." aria-label="Search" aria-describedby="basic-addon2" value="{{Session::get('keyword')}}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}
            <!-- Navbar -->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hi, {{substr(Auth::user()->name, 0, 7)}}
                        <i class="fas fa-user-circle fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">My Profile</a>
                        {{-- <a class="dropdown-item" href="#">Activity Log</a> --}}
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="sidebar navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL::route('home') }}">
                        <i class="fas fa-fw fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#addFolderModal" data-toggle="modal">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Create Folder</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#uploadFilesModal" data-toggle="modal">
                        <i class="fas fa-fw fa-cloud-upload-alt"></i>
                        <span>Upload Files</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL::route('trash') }}">
                        <i class="fas fa-fw fa-trash"></i>
                        <span>Trash</span></a>
                    </li>
                </ul>
                @yield('content')
                <!-- /.content-wrapper -->
            {{-- </div> --}}
            <!-- /#wrapper -->
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="{{ URL::route('logout') }}">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="addFolderModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {!! Form::open(['route' => 'create.folder', 'method'=> 'POST', 'id' => 'create-folder-form']) !!}
                        <div class="modal-header">
                            <h4 class="modal-title">Create New Folder</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger ajax-error"  style="display:none;">
                                <span class="status"></span>
                            </div>
                            <div class="form-group">
                                <label>Folder Name</label>
                                <input type="text" class="form-control" name="folder_name" required>
                            </div>
                            <input type="hidden" name="source" value="{{ @$source->folder_uid }}" id ="folderSource">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-block btn-success mySubmitBtn">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
                <!-- BEGIN Loader -->
                <div class="modal fade" tabindex="-1" role="dialog" id="waitLoader">
                    <div class="modal-dialog modal-dialog-centered text-center" role="document">
                        <span class="fa fa-spinner fa-spin fa-3x w-100"></span>
                    </div>
                </div
                <!-- END Loader  -->
                <!-- Modal Boxe START for DELETE -->
                <div class="modal fade" id="delete-confirm" role="dialog">
                    <div class="modal-dialog" style="width:360px;">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="mx-auto text-center">
                                    <span class="text-center"><i class="fa fa-exclamation-triangle fa-2x text-danger"></i></span>
                                </div>
                                <h4>Are you sure you want to proceed?</h4>
                            </div>
                            <div class="modal-footer" style="text-align: center;">
                                <a href="#" class="btn btn-outline-danger confirm">Yes</a>
                                <button type="button" class="btn default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Boxe END for DELETE -->
                <!-- Modal Boxe START for Upload Files -->
                <div id="uploadFilesModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            {!! Form::open(['route' => 'upload.files', 'method'=> 'POST', 'id' => 'upload-file-form', 'enctype' => 'multipart/form-data']) !!}
                            <div class="modal-header">
                                <h4 class="modal-title">Upload Files</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger ajax-error"  style="display:none;">
                                    <span class="status"></span>
                                </div>
                                <div class="form-group">
                                    <input type="file" id="multiupload1" name="files[]" required="true" multiple >
                                </div>
                                <div id="uploadsts"></div>
                                  <input type="hidden" name="source" value="{{ @$source->folder_uid }}" id ="folderSource">
                            </div>
                            <div class="modal-footer">
                                    <button type="submit" id="upcvr" class="btn btn-block btn-success mySubmitBtn">Upload</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
@yield('script')

@include('layout.common-js')

</body>
</html>