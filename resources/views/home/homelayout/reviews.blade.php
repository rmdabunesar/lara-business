<div class="lonyo-section-padding position-relative overflow-hidden">
    <div class="container">
        <div class="lonyo-section-title">
            <div class="row">
                @php
                    $title = \App\Models\Title::firstOrCreate(['id' => 1]);
                @endphp
                <div class="col-xl-8 col-lg-8">
                    <h2 id="reviews-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                        data-id="{{ $title->id }}" data-field="reviews">{{ $title->reviews }}</h2>
                </div>
                <div class="col-xl-4 col-lg-4 d-flex align-items-center justify-content-end">
                    <div class="lonyo-title-btn">
                        <a class="lonyo-default-btn t-btn" href="contact-us.html">Read Customer Stories</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lonyo-testimonial-slider-init">

        @php
            $reviews = \App\Models\Review::latest()->get();
        @endphp

        @foreach ($reviews as $item)
            <div class="lonyo-t-wrap wrap1 light-bg">
                <div class="lonyo-t-ratting">
                    <img src="{{ asset('frontend/assets/images/shape/star.svg') }}" alt="">
                </div>
                <div class="lonyo-t-text">
                    <p>{{ $item->message }}</p>
                </div>
                <div class="lonyo-t-author">
                    <div class="lonyo-t-author-thumb">
                        <img src="{{ $item->image ? asset($item->image) : asset('frontend/assets/images/v1/img7.png') }}"
                            alt="">
                    </div>
                    <div class="lonyo-t-author-data">
                        <p>{{ $item->name }}</p>
                        <span>{{ $item->position }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="lonyo-t-overlay2">
        <img src="{{ asset('frontend/assets/images/v2/overlay.png') }}" alt="">
    </div>
</div>


{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const title = document.getElementById('reviews-title');

        if (!title || title.getAttribute('contenteditable') !== 'true') return;

        function saveChanges() {
            const formData = new FormData();
            formData.append('id', title.dataset.id);
            formData.append('field', title.dataset.field);
            formData.append('value', title.innerText.trim());

            fetch('{{ route('edit.title') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });
        }

        title.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                title.blur();
            }
        });

        title.addEventListener('blur', saveChanges);
    });
</script>
