@extends('layouts.dashboard')

@section('title', 'تحرير القسم')

@section('breadcrumb')
    @parent
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-400 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">الاقسام</li>
    <!--end::Item-->
@endsection
@section('content')
    <form id="kt_ecommerce_add_category_submit" method="POST" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data" action ="{{route('categories.update', $category->id)}}">
        @csrf
        @method('PUT')
         <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <!--begin::Thumbnail settings-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>صورة للقسم</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body text-center pt-0">
                    <!--begin::Image input-->
                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                         style="background-image: url({{asset('storage/'.$category->image)}})">
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
                    <div class="text-muted fs-7">تعيين الصورة المصغرة للقسم. تقبل فقط ملفات الصور * .png و * .jpg و * .jpeg</div>
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
                        <h2>حالة القسم</h2>
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
                        <option value="published" selected="selected">نشط</option>
                        <option value="unpublished">متوقف</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{$message}}</span>
                    @enderror

                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">قم بتعيين حالة القسم</div>

                    <!--end::Description-->

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
                        <h2>بيانات القسم</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">اسم القسم</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="category_name" class="form-control mb-2 @error('category_name') is-invalid @enderror" placeholder="Product name" value="{{old('category_name') ?? $category->category_name}}" />
                        @error('category_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">مطلوب اسم القسم ويوصى به ليكون فريدًا</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div>
                        <!--begin::Label-->
                        <label class="form-label">الوصف</label>
                        <!--end::Label-->
                        <!--begin::Editor-->
                        <textarea id="category_description" class="form-control mb-2 @error('category_description') is-invalid @enderror"  name="category_description" rows="4" cols="50" placeholder="category description">{{old('category_description') ?? $category->category_description}}
                        </textarea>

                        @error('category_description')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <!--end::Editor-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">قم بتعيين وصف للقسم للحصول على رؤية أفضل.</div>
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
                                    <h2>القسم الرئيسي</h2>
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
                                        <option value="{{$category->id}}" @selected($category->parent_id == $category->id)>{{$category->category_name}}</option>
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
                <a href="#" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">الغاء</a>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                    <span class="indicator-label">حفظ التغيرات</span>
                    <span class="indicator-progress"انتظر قليلا...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
@endsection




