@extends('home.home_master')

@section('home')
    @include('home.homelayout.slider')
    <div class="lonyo-content-shape1">
        <img src="{{ asset('frontend/assets/images/shape/shape1.svg') }}" alt="">
    </div>
    <!-- end hero -->

    @include('home.homelayout.features')
    <!-- end features -->

    @include('home.homelayout.clarifies')
    <!-- end clarifies -->

    @include('home.homelayout.financial')
    <div class="lonyo-content-shape3">
        <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
    </div>
    <!-- end financial -->

    @include('home.homelayout.usability')
    <div class="lonyo-content-shape1">
        <img src="{{ asset('frontend/assets/images/shape/shape3.svg') }}" alt="">
    </div>
    <!-- end usability -->

    @include('home.homelayout.reviews')
    <!-- end reviews -->

    @include('home.homelayout.faq')
    <div class="lonyo-content-shape3">
        <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
    </div>
    <!-- end faq -->

    @include('home.homelayout.apps')
    <!-- end apps -->
@endsection
