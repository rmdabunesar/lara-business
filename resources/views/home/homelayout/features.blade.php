<div class="lonyo-section-padding2 position-relative">
    <div class="container">
        @php
            $title = \App\Models\Title::firstOrCreate(['id' => 1]);
        @endphp
        <div class="lonyo-section-title center">
            <h2 id="features-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                data-id="{{ $title->id }}" data-field="features">{{ $title->features }}</h2>
        </div>
        <div class="row">

            @php
                $features = \App\Models\Feature::latest()->get();
                $durations = [500, 700, 900];
            @endphp

            @foreach ($features as $item)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="lonyo-service-wrap light-bg" data-aos="fade-up"
                        data-aos-duration="{{ $durations[$loop->index % 3] }}">
                        <div class="lonyo-service-title">
                            <h4>{{ $item->title }}</h4>
                            <img src="{{ $item->icon ? asset($item->icon) : asset('frontend/assets/images/v1/feature1.svg') }}"
                                alt="">
                        </div>
                        <div class="lonyo-service-data">
                            <p>{{ $item->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="lonyo-feature-shape"></div>
</div>


{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const title = document.getElementById('features-title');

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
