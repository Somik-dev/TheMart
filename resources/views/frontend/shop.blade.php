@extends('frontend.master')
@section('content')

<!-- start wpo-page-title -->
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="index.html">Home</a></li>
                        <li>Shop</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- product-area-start -->
<div class="shop-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="shop-filter-wrap">
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <div class="shop-filter-search">
                                <form>
                                    <div>
                                        <input id="search_input2" type="text" class="form-control" placeholder="Search..">
                                        <button class="search_btn2" type="button"><i class="ti-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Shop by Category</h2>
                            <ul>
                                @foreach ($categories as $category)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{ $category->category_name }} <span>({{ App\Models\newproduct::where('category_id',$category->id)->count() }})</span>
                                        <input name="category_id" class="category_id" type="radio"  value="{{ $category->id }}">
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Filter by price</h2>
                            <div class="shopWidgetWraper">
                                <div class="priceFilterSlider">
                                        {{--  <!-- <div id="sliderRange"></div>
                                        <div class="pfsWrap">
                                            <label>Price:</label>
                                            <span id="amount"></span>
                                        </div> -->  --}}
                                        <div class="d-flex">
                                            <div class="col-lg-6 pe-2">
                                                <label for="" class="form-label">Min</label>
                                                <input id="min" type="text" class="form-control" placeholder="Min" >
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="" class="form-label">Max</label>
                                                <input id="max" type="text" class="form-control" placeholder="Max">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <button id="price_range" class="form-control bg-light">Submit</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Color</h2>
                            <ul>
                                @foreach ($colors as $color)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{ $color->color_name }} <span>(21)</span>
                                        <input class="color_id" type="radio" name="topcoat2" value="{{ $color->id }}">
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Size</h2>
                            <ul>
                                @foreach ($sizes as $size)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{  $size->size_name }} <span>(10)</span>
                                        <input class="size_id" type="radio" name="topcoat3" value="{{ $size->id }}">
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item tag-widget">
                            <h2>Popular Tags</h2>
                            <ul>
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Shoes</a></li>
                                <li><a href="#">Kids</a></li>
                                <li><a href="#">Theme</a></li>
                                <li><a href="#">Stylish</a></li>
                                <li><a href="#">Women</a></li>
                                <li><a href="#">Shop</a></li>
                                <li><a href="#">Men</a></li>
                                <li><a href="#">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="shop-section-top-inner">
                    <div class="shoping-product">
                        <p>We found <span>{{ $products->count() }} items</span> for you!</p>
                    </div>
                    <div class="short-by">
                        <ul>
                            <li>
                                Sort by:
                            </li>
                            <li>
                                <select name="show">
                                    <option value="">Default Sorting</option>
                                    <option value="1">Low To High</option>
                                    <option value="2">High To Low</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-wrap">
                    <div class="row align-items-center">
                         @forelse ($products as $product)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img height="200" src="{{ asset('uploads/products/preview') }}/{{ $product->preview }}" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="{{ route('product.details',$product->slug) }}">
                                        @if (strlen($product->product_name) > 15)
                                        {{ Str::substr($product->product_name, 0, 15). '...' }}
                                       @else
                                         {{ $product->product_name }}
                                       @endif
                                    </a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>130</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">&#2547;{{  number_format($product->after_discount) }}</span>
                                        <del class="old-price">&#2547;{{ number_format($product->price) }}</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="{{ route('product.details',$product->slug) }}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h2>No search product found</h2>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-area-end -->


@endsection


@section('footer_script')

<script>
    $('.ddd').click(function(){

    var cat = $('#top_cat').val();




         let search_input = $('#search_input').val();
        var category_id = $("input[type = 'radio'][name = 'category_id']:checked").val();
        var min = $('#min').val();
        var max = $('#max').val();



        let link = "{{ route('shop') }}" + "?search_input="+ search_input+"&category_id="+category_id+"&category2_id="+cat
        +"&min="+min+"&max="+max;
        window.location.href = link;
    });




    $('.search_btn2').click(function(){
        let search_input2 = $('#search_input2').val();
        let link = "{{ route('shop') }}" + "?search_input="+ search_input2;
        window.location.href = link;
    })
 </script>

@endsection
