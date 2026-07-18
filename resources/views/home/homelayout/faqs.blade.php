<div class="lonyo-section-padding4">
    <div class="container">
        @php
            $title = \App\Models\Title::firstOrCreate(['id' => 1]);
        @endphp
        <div class="lonyo-section-title center">
            <h2 id="faqs-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}" data-id="{{ $title->id }}"
                data-field="faqs">{{ $title->faqs ?? 'Frequently Asked Questions' }}</h2>
        </div>
        <div class="lonyo-faq-shape"></div>
        <div class="lonyo-faq-wrap1">
            @php
                $faqs = \App\Models\Faqs::latest()->get();
            @endphp
            @foreach ($faqs as $faq)
            <div class="lonyo-faq-item item2 open" data-aos="fade-up" data-aos-duration="500">
                <div class="lonyo-faq-header">
                    <h4>{{ $faq->question }}</h4>
                    <div class="lonyo-active-icon">
                        <img class="plasicon" src="{{ asset('frontend/assets/images/v1/mynus.svg') }}" alt="">
                        <img class="mynusicon" src="{{ asset('frontend/assets/images/v1/plas.svg') }}" alt="">
                    </div>
                </div>
                <div class="lonyo-faq-body body2">
                    <p>{{ $faq->answer }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const title = document.getElementById('faqs-title');

        if (!title || title.getAttribute('contenteditable') !== 'true') return;

        function saveChanges() {
            const formData = new FormData();
            formData.append('id', title.dataset.id);
            formData.append('field', title.dataset.field);
            formData.append('value', title.innerText.trim());

            fetch('{{ route('edit.title') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
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
