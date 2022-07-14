@extends('admin::layouts.layout_2.LTR.navbar_fixed_main')

@section('title', 'Admin :: User :: Create')

@section('head')
    <script src="{{ mix('/template/limitless/layout_2/LTR/default/assets/mix/chat_of_account.js') }}"></script>
@endsection

@section('content')


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light" style="border-bottom: 1px solid #ddd;">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h2 class="no-margin">
                        <i class="icon-file-plus position-left"></i> New User
                    </h2>
                </div>
            </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">

            <div class="card bg-transparent border-0 shadow-0 col-md-6">


					<div class="card-body">

                        {{--<p class="mb-4"><code>*</code>, means fields is required.</p>--}}

						<form action="{{route('admin.apps.store')}}" method="post">
                            @csrf
                            @method('POST')

							<fieldset class="mb-3">

								<div class="form-group row">
									<label for="service-name" class="col-form-label col-lg-2">Name</label>
									<div class="col-lg-8">
										<input id="service-name" type="text" name="name" class="form-control" placeholder="Service Name">
									</div>
								</div>

								<div class="form-group row">
									<label for="service-description" class="col-form-label col-lg-2">Description</label>
									<div class="col-lg-8">
										<textarea id="service-description" name="description" rows="3" cols="3" class="form-control" placeholder="Service Description"></textarea>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-2"> </label>
									<div class="col-lg-8">
										<button type="submit" class="btn btn-danger"><i class="icon-paperplane mr-2"></i> Save</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

@endsection
