
@extends('layouts.dashboard')

@section('title', 'اضافة منتج')

@section('breadcrumb')
@parent
<!--begin::Item-->
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<!--end::Item-->
<!--begin::Item-->
<li class="breadcrumb-item text-muted">المنتجات</li>
<!--end::Item-->
@endsection
@section('content')
<!--begin::Form-->
<form id="kt_ecommerce_add_product_form" method="POST" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data" action ="{{route('products.store')}}">
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
                    <h2>صورة المنتج</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body text-center pt-0">
                <!--begin::Image input-->
                <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url({{asset('assets/media/svg/files/blank-image.svg')}})">
                    <!--begin::Preview existing avatar-->
                    <div class="image-input-wrapper w-150px h-150px"></div>
                    <!--end::Preview existing avatar-->
                    <!--begin::Label-->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                        <i class="bi bi-pencil-fill fs-7"></i>
                        <!--begin::Inputs-->
                        <input type="file" name="product_image" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" name="avatar_remove" />
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
                <div class="text-muted fs-7">قم بتعيين الصورة المصغرة للمنتج. تقبل فقط ملفات الصور * .png و * .jpg و * .jpeg
                </div>
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
                    <h2>حالة المنتج</h2>
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <div class="rounded-circle bg-success w-15px h-15px" id="status"></div>
                </div>
                <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Select2-->
                <select id="status" name="status" class="form-select mb-2 @error('status') is-invalid @enderror" data-control="select2" data-hide-search="true" data-placeholder="Select an option">
                    <option></option>
                    <option value="published" selected="selected">نشر</option>
                    <option value="scheduled">مجدول</option>
                    <option value="unpublished">غير منشور</option>
                </select>
                <!--end::Select2-->
                <!--begin::Description-->
                <div class="text-muted fs-7">قم بتعيين حالة المنتج.
                </div>
                <!--end::Description-->
                <!--begin::Datepicker-->
                <div class="d-none mt-10">
                    <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select publishing date and time</label>
                    <input class="form-control" id="kt_ecommerce_add_product_status_datepicker" placeholder="Pick date &amp; time" />
                </div>
                <!--end::Datepicker-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Status-->

        <!--begin::Category & tags-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>تفاصيل المنتج</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">المتاجر</label>
                <!--end::Label-->
                <!--begin::Select2-->
                <select id="store_id" name="store_id" class="form-select mb-2  @error('store_id') is-invalid @enderror" data-control="select2" data-hide-search="true" data-placeholder="Select an option">

                    @foreach($stores as $store)
                        <option value="{{$store->id}}" selected="selected">{{$store->store_name}}</option>
                    @endforeach
                </select>
                <!--end::Select2-->
                <!--begin::Description-->
                <div class="text-muted fs-7 mb-7">أضف منتجًا إلى قسم.</div>
                <!--end::Description-->
                <!--end::Input group-->

            </div>
            <!--end::Card body-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Input group-->
                <!--begin::Label-->
                <label class="form-label">الاقسام</label>
                <!--end::Label-->
                <!--begin::Select2-->
                <select id="category_id" name="category_id" class="form-select mb-2  @error('category_id') is-invalid @enderror" data-control="select2" data-hide-search="true" data-placeholder="Select an option">

                    @foreach($categories as $category)
                        <option value="{{$category->id}}" selected="selected">{{$category->category_name}}</option>
                    @endforeach
                </select>
                <!--end::Select2-->
                <!--begin::Description-->
                <div class="text-muted fs-7 mb-7">أضف منتجًا إلى قسم.</div>
                <!--end::Description-->
                <!--end::Input group-->
                <!--begin::Button-->
                <a href="{{route('categories.create')}}" class="btn btn-light-primary btn-sm mb-10">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                    <span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="black" />
														<rect x="6" y="11" width="12" height="2" rx="1" fill="black" />
													</svg>
												</span>
                    <!--end::Svg Icon-->أنشئ قسم جديدة</a>
                <!--end::Button-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Category & tags-->


    </div>
    <!--end::Aside column-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                <div class="d-flex flex-column gap-7 gap-lg-10">
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>تفاصيل المنتج</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">اسم النتج</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="product_name" class="form-control mb-2" placeholder="Product name" value="" />
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">مطلوب اسم منتج ويوصى به ليكون فريدًا.
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">وصف المنتج</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <textarea id="product_description" class="form-control mb-2 @error('product_description') is-invalid @enderror"  name="product_description" rows="4" cols="50" placeholder="product description"></textarea>
                                <!--end::Editor-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">قم بتعيين وصف للمنتج للحصول على رؤية أفضل.
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->

                    <!--begin::Pricing-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>التسعير</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">السعر الأساسي</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="base_price" class="form-control mb-2" placeholder="Product price" value="" />
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">حدد سعر المنتج.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->

                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Pricing-->
                    <!--begin::Inventory-->
                    <div class="card card-flush py-4">

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">SKU</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="sku" class="form-control mb-2" placeholder="SKU Number" value="" />
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Enter the product SKU.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">كمية</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="d-flex gap-3">
                                    <input type="number" name="Quantity" class="form-control mb-2" placeholder="On shelf" value="" />
                                </div>
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">أدخل كمية المنتج.
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->

                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Inventory-->
                </div>
            </div>
            <!--end::Tab pane-->
            <!--begin::Tab pane-->
             <!--end::Tab pane-->
        </div>
        <!--end::Tab content-->
        <div class="d-flex justify-content-end">
            <!--begin::Button-->
            <a href="#" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="submit" id="kt_ecommerce_add_product_form" class="btn btn-primary">
                <span class="indicator-label">Save Changes</span>
                <span class="indicator-progress">Please wait...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
        </div>
    </div>
    <!--end::Main column-->
</form>
<!--end::Form-->
@endsection

@push('child-scripts')
<script src="{{asset('assets/js/custom/apps/ecommerce/catalog/save-product.js')}}"></script>
@endpush


