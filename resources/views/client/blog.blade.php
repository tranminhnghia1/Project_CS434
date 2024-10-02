@extends('layouts.client')

@section('content')
    <div id="main-content-wp" class="clearfix blog-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Blog</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title">Blog</h3>
                    </div>
                    <div class="section-detail">
                        @foreach ($blogs as $blog)
                            <ul class="list-item">

                                <li class="clearfix">
                                    <a href="{{ route('detail_blog',$blog->id) }}" title="" class="thumb fl-left">
                                        <img src="{{ asset($blog->thumnail) }}" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="{{ route('detail_blog',$blog->id) }}" title="" class="title">{{ $blog->name }}</a>
                                        <span class="create-date">{{ $blog->created_at }}</span>
                                        <p class="desc">{!! Str::of($blog->content)->limit(150) !!}</p>
                                    </div>
                                </li>



                            </ul>
                        @endforeach
                    </div>
                </div>
                <div class="section" id="paging-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                {{ $blogs->links() }}
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="sidebar fl-left">
                <div class="section" id="selling-wp">
                    @include('client.components.sidebar-productTop')
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        @foreach ($banners as $item)
                            <a href="" title="" class="thumb">
                                <img style="    margin-bottom: 18px;" src="{{ asset($item->product_thumb) }}" alt="">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>

    </style>
@endsection
