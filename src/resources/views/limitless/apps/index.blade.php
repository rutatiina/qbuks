@extends('admin::layouts.layout_2.LTR.navbar_fixed_main')

@section('title', 'Admin :: Apps')

@section('head')

@endsection

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Ruginem</span> - Apps</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="{{route('admin.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <a href="{{route('admin.apps.index')}}" class="breadcrumb-item">Apps</a>
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
            </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">

            <!-- Table components -->
            <div class="card bg-transparent border-0 shadow-0">


                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Actions</th>
                                <th>Status</th>
                                <th>Clients</th>
                                <th>Priority</th>
                                <th>Target completed</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($apps as $app)
                            <tr>
                                <td>{{$app->name}}</td>
                                <td>
                                    <div class="list-icons">
                                        <a href="#" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-trash"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-cog6"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-success">Active</span>
                                    <span class="badge badge-flat border-success text-success-600 ml-2">Development ongoing</span>
                                </td>
                                <td>
                                    <span class="badge badge-success badge-pill font-weight-bold" title="Clients : Active">430,000</span>
                                    <span class="badge badge-flat border-primary font-weight-bold text-primary badge-pill ml-2" title="Clients : Testing">190</span>
                                    <span class="badge badge-flat border-danger font-weight-bold text-danger-600 badge-pill ml-2" title="Clients : Unsubed">14</span>
                                </td>
                                <td>
                                    <div class="badge bg-danger">High Priority</div>
                                </td>
                                <td>
                                    <div class="badge bg-indigo-400 badge-pill"><strong>70%</strong> | Manage, Upload Transactions Update</div>
                                </td>
                            </tr>
                        @endforeach

                            <tr>
                                <td> Accounting</td>
                                <td>
                                    <div class="list-icons">
                                        <a href="#" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-trash"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-cog6"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-success">Active</span>
                                    <span class="badge badge-flat border-success text-success-600 ml-2">Development ongoing</span>
                                </td>
                                <td>
                                    <span class="badge badge-success badge-pill font-weight-bold" title="Clients : Active">430,000</span>
                                    <span class="badge badge-flat border-primary font-weight-bold text-primary badge-pill ml-2" title="Clients : Testing">190</span>
                                    <span class="badge badge-flat border-danger font-weight-bold text-danger-600 badge-pill ml-2" title="Clients : Unsubed">14</span>
                                </td>
                                <td>
                                    <div class="badge bg-danger">High Priority</div>
                                </td>
                                <td>
                                    <div class="badge bg-indigo-400 badge-pill"><strong>70%</strong> | Manage, Upload Transactions Update</div>
                                </td>
                            </tr>

                            <tr>
                                <td> HRM</td>
                                <td>
                                    <div class="list-icons">
                                        <a href="#" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-trash"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-cog6"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-danger">In progress</span>
                                    <span class="badge badge-flat border-warning text-warning ml-2">In Development</span>
                                </td>
                                <td>
                                    <span class="badge badge-success badge-pill font-weight-bold" title="Clients : Active">230,000</span>
                                    <span class="badge badge-flat border-primary font-weight-bold text-primary badge-pill ml-2" title="Clients : Testing">450</span>
                                    <span class="badge badge-flat border-danger font-weight-bold text-danger-600 badge-pill ml-2" title="Clients : Unsubed">5</span>
                                </td>
                                <td>
                                    <div class="badge bg-primary">Normal Priority</div>
                                </td>
                                <td>
                                    <div class="badge bg-indigo-400 badge-pill"><strong>30%</strong> | In development</div>
                                </td>
                            </tr>

                            <tr>
                                <td> USSD</td>
                                <td>
                                    <div class="list-icons">
                                        <a href="#" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-trash"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-cog6"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-danger">In progress</span>
                                    <span class="badge badge-flat border-warning text-warning ml-2">In Development</span>
                                </td>
                                <td>
                                    <span class="badge badge-success badge-pill font-weight-bold" title="Clients : Active">645,345</span>
                                    <span class="badge badge-flat border-primary font-weight-bold text-primary badge-pill ml-2" title="Clients : Testing">234</span>
                                    <span class="badge badge-flat border-danger font-weight-bold text-danger-600 badge-pill ml-2" title="Clients : Unsubed">6</span>
                                </td>
                                <td>
                                    <div class="badge badge-light">Low Priority</div>
                                </td>
                                <td>
                                    <div class="badge bg-indigo-400 badge-pill"><strong>20%</strong> | In development</div>
                                </td>
                            </tr>

                            <tr>
                                <td> Order</td>
                                <td>
                                    <div class="list-icons">
                                        <a href="#" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-trash"></i></a>
                                        <a href="#" class="list-icons-item"><i class="icon-cog6"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-danger">In progress</span>
                                    <span class="badge badge-flat border-warning text-warning ml-2">In Development</span>
                                </td>
                                <td>
                                    <span class="badge badge-success badge-pill font-weight-bold" title="Clients : Active">545,324,234</span>
                                    <span class="badge badge-flat border-primary font-weight-bold text-primary badge-pill ml-2" title="Clients : Testing">456</span>
                                    <span class="badge badge-flat border-danger font-weight-bold text-danger-600 badge-pill ml-2" title="Clients : Unsubed">5</span>
                                </td>
                                <td>
                                    <div class="badge bg-success">Low Priority</div>
                                </td>
                                <td>
                                    <div class="badge bg-indigo-400 badge-pill"><strong>14%</strong> | Update</div>
                                    <div class="badge bg-indigo-400 badge-pill">50% | Update</div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /table components -->


            <!-- Edit modal -->
            <div id="edit_modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <h5 class="modal-title">Edit table</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                        <th class="col-xs-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" value="Mark"></td>
                                        <td><input type="text" class="form-control" value="Otto"></td>
                                        <td><input type="text" class="form-control" value="@mdo"></td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <a href="#" class="list-icons-item"><i class="icon-plus3 font-size-base"></i></a>
                                                <a href="#" class="list-icons-item"><i class="icon-cross2 font-size-base"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="form-control" value="Jacob"></td>
                                        <td><input type="text" class="form-control" value="Thornton"></td>
                                        <td><input type="text" class="form-control" value="@fat"></td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <a href="#" class="list-icons-item"><i class="icon-plus3 font-size-base"></i></a>
                                                <a href="#" class="list-icons-item"><i class="icon-cross2 font-size-base"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="form-control" value="Larry"></td>
                                        <td><input type="text" class="form-control" value="the Bird"></td>
                                        <td><input type="text" class="form-control" value="@twitter"></td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <a href="#" class="list-icons-item"><i class="icon-plus3 font-size-base"></i></a>
                                                <a href="#" class="list-icons-item"><i class="icon-cross2 font-size-base"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer bg-transparent">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /edit modal -->


            <!-- Remove modal -->
            <div id="remove_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm action</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            You are about to remove this row. Are you sure?
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Yes, remove</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal">No, thanks</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /remove modal -->


            <!-- Options modal -->
            <div id="options_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Row options</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form action="">
                                <div class="form-group row">
                                    <label class="font-weight-semibold col-form-label col-sm-3">Allow select:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-select2" data-fouc>
                                            <option value="single" selected>Single</option>
                                            <option value="multiple">Multiple</option>
                                            <option value="disabled">Disabled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="font-weight-semibold col-form-label col-sm-3">Allow edit:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-select2" data-fouc>
                                            <option value="inline">Edit inline</option>
                                            <option value="modal" selected>Edit in modal</option>
                                            <option value="popover">Edit in popover</option>
                                            <option value="disabled">Disabled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="font-weight-semibold col-form-label col-sm-3">Add status:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-select2" data-fouc>
                                            <option value="completed" selected>Completed</option>
                                            <option value="progress">In progress</option>
                                            <option value="assigned">Assigned</option>
                                            <option value="created">Created</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="font-weight-semibold col-form-label col-sm-3">Set priority:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-select2-actions" data-fouc>
                                            <option value="urgent" data-icon="radio-checked text-danger" selected>Urgent</option>
                                            <option value="high" data-icon="radio-checked text-primary">High</option>
                                            <option value="normal" data-icon="radio-checked text-success">Normal</option>
                                            <option value="low" data-icon="radio-checked text-info">Low</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="font-weight-semibold col-form-label col-sm-3" for="enable-controls">Enable controls:</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-switchery">
                                            <input type="checkbox" class="form-input-switchery-controls" id="enable_controls" checked data-fouc>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="font-weight-semibold col-form-label col-sm-3">Controls:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-select2-actions" id="available_controls" multiple="multiple">
                                            <option value="edit" data-icon="pencil7" selected>Edit</option>
                                            <option value="remove" data-icon="trash" selected>Remove</option>
                                            <option value="options" data-icon="cog4" selected>Options</option>
                                            <option value="add" data-icon="plus22">Add</option>
                                            <option value="add" data-icon="versions">Copy</option>
                                            <option value="select" data-icon="check">Select</option>
                                            <option value="mark" data-icon="file-download">Export</option>
                                            <option value="mark" data-icon="file-upload">Import</option>
                                            <option value="mark" data-icon="printer">Print</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Save settings</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /options modal -->

        </div>
        <!-- /content area -->


        <!-- Footer -->
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                    <i class="icon-unfold mr-2"></i>
                    Footer
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-footer">
                <span class="navbar-text">
                    &copy; 2015 - 2018. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
                </span>

                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
                    <li class="nav-item"><a href="http://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
                    <li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
                </ul>
            </div>
        </div>
        <!-- /footer -->

    </div>
    <!-- /main content -->

@endsection
