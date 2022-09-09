@extends('layouts.dashboard')

@section('title', 'Add Category')

@section('breadcrumb')
    @parent
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-400 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">Category</li>
    <!--end::Item-->
@endsection
@section('content')


    <form id="kt_ecommerce_add_category_submit" method="POST" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data" action ="{{route('categories.store')}}">
        @csrf
        @method('POST')
         <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <!--begin::Thumbnail settings-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Thumbnail</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body text-center pt-0">
                    <!--begin::Image input-->
                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                         style="background-image: url({{asset('assets/media/svg/files/blank-image.svg')}})">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-150px h-150px"></div>
                        <!--end::Preview existing avatar-->
                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <!--begin::Icon-->
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <!--end::Icon-->
                            <!--begin::Inputs-->
                            <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                            @error('image')
                                <span class="text-danger">{{$message}}</span>
                            @enderror


                            <!--end::Inputs-->
                        </label>
                        <!--end::Label-->
                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
														<i class="bi bi-x fs-2"></i>
													</span>
                        <!--end::Cancel-->
                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
														<i class="bi bi-x fs-2"></i>
													</span>
                        <!--end::Remove-->
                    </div>
                    <!--end::Image input-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Set the category thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                    <!--end::Description-->

                </div>
                <!--end::Card body-->

            </div>
            <!--end::Thumbnail settings-->
            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-success w-15px h-15px" id="category_status"></div>
                    </div>
                    <!--begin::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Select2-->
                    <select id="category_status" name="status" class="form-select mb-2 @error('status') is-invalid @enderror" data-control="select2" data-hide-search="true" data-placeholder="Select an option">
                        <option></option>
                        <option value="published" selected="selected">Published</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="unpublished">Unpublished</option>
                    </select>
@error('status')
    <span class="text-danger">{{$message}}</span>
@enderror

                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Set the category status.</div>

                    <!--end::Description-->
                    <!--begin::Datepicker-->
                    <div class="d-none mt-10">
                        <label for="kt_ecommerce_add_category_status_datepicker" class="form-label">Select publishing date and time</label>
                        <input class="form-control" id="kt_ecommerce_add_category_status_datepicker" placeholder="Pick date &amp; time" />
                    </div>
                    <!--end::Datepicker-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->


        </div>
        <!--end::Aside column-->
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>General</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Category Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="category_name" class="form-control mb-2 @error('category_name') is-invalid @enderror" placeholder="Product name" value="{{old('category_name')}}" />
                        @error('category_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">A category name is required and recommended to be unique.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div>
                        <!--begin::Label-->
                        <label class="form-label">Description</label>
                        <!--end::Label-->
                        <!--begin::Editor-->
                         <textarea id="category_description" class="form-control mb-2 @error('category_description') is-invalid @enderror"  name="category_description" rows="4" cols="50" placeholder="category description"></textarea>

                        @error('category_description')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <!--end::Editor-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Set a description to the category for better visibility.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Status-->
                    @if($categories->count() > 0 )
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Parent Category</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <div class="rounded-circle bg-success w-15px h-15px" id="parent_id"></div>
                            </div>
                            <!--begin::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Select2-->
                            <select id="parent_id" name="parent_id" class="form-select mb-2  @error('parent_id') is-invalid @enderror" data-control="select2" data-hide-search="true" data-placeholder="Select an option">

                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" selected="selected">{{$category->category_name}}</option>
                                    @endforeach
                            </select>
                            <!--end::Select2-->
                            @error('parent_id')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <!--end::Card body-->
                    </div>
                    @endif
                    <!--end::Status-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::General options-->

            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="#" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
 @endsection

@push('child-scripts')
    <script src="{{asset('assets/js/custom/apps/ecommerce/catalog/save-category.js')}}"></script>
@endpush



