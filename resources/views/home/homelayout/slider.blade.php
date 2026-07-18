@php
    $slider = \App\Models\Slider::first();
    $editable = auth()->check() && $slider;
@endphp

<div class="lonyo-hero-section light-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 d-flex align-items-center">
                <div class="lonyo-hero-content" data-aos="fade-up" data-aos-duration="700">
                    <h1 id="slider-title" contenteditable="{{ $editable ? 'true' : 'false' }}"
                        data-id="{{ $slider?->id }}" data-field="title" class="hero-title">
                        {{ $slider?->title ?? 'Manage your finances more effectively' }}</h1>
                    <p id="slider-description" contenteditable="{{ $editable ? 'true' : 'false' }}"
                        data-id="{{ $slider?->id }}" data-field="description" class="text">
                        {{ $slider?->description ?? 'Track your daily finances automatically. Manage your money in a friendly & flexible way, making it easy to spend guilt-free.' }}
                    </p>
                    <div class="mt-50" data-aos="fade-up" data-aos-duration="900">
                        <a href="{{ $slider?->link ?? url('/register') }}" id="slider-button"
                            contenteditable="{{ $editable ? 'true' : 'false' }}" data-id="{{ $slider?->id }}"
                            data-field="button_text"
                            class="lonyo-default-btn hero-btn">{{ $slider?->button_text ?? 'Learn More' }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="lonyo-hero-thumb" data-aos="fade-left" data-aos-duration="700">
                    <img src="{{ $slider?->image ? asset($slider->image) : 'https://placehold.co/600x600?text=Slider+Image' }}"
                        alt="">
                    <div class="lonyo-hero-shape">
                        <img src="{{ asset('frontend/assets/images/shape/hero-shape1.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const title = document.getElementById('slider-title');
        const description = document.getElementById('slider-description');
        const button = document.getElementById('slider-button');

        // Only enable inline editing for logged-in admins
        if (title.getAttribute('contenteditable') !== 'true') return;

        function saveChanges() {
            const formData = new FormData();
            formData.append('id', title.dataset.id);
            formData.append('title', title.innerText.trim());
            formData.append('description', description.innerText.trim());
            formData.append('button_text', button.innerText.trim());
            formData.append('link', @json($slider?->link ?? ''));

            fetch('{{ route('update.slider') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });
        }

        // Prevent form submission on Enter key press and save changes on blur
        [title, description, button].forEach(element => {
            element.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    element.blur();
                }
            });

            element.addEventListener('blur', saveChanges);
        });

        button.addEventListener('click', event => event.preventDefault());
    });
</script>
