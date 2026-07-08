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
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="lonyo-service-wrap light-bg" data-aos="fade-up" data-aos-duration="500">
                    <div class="lonyo-service-title">
                        <h4>Expense Tracking</h4>
                        <img src="{{ asset('frontend/assets/images/v1/feature1.svg') }}" alt="">
                    </div>
                    <div class="lonyo-service-data">
                        <p>Allows users to record and categorize daily transactions such as income, expenses, bills, and
                            savings.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="lonyo-service-wrap light-bg" data-aos="fade-up" data-aos-duration="700">
                    <div class="lonyo-service-title">
                        <h4>Budgeting Tools</h4>
                        <img src="{{ asset('frontend/assets/images/v1/feature2.svg') }}" alt="">
                    </div>
                    <div class="lonyo-service-data">
                        <p>Provides visual insights like graphs or pie charts to show how much is spent versus the
                            budgeted amount.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="lonyo-service-wrap light-bg" data-aos="fade-up" data-aos-duration="900">
                    <div class="lonyo-service-title">
                        <h4>Investment Tracking</h4>
                        <img src="{{ asset('frontend/assets/images/v1/feature3.svg') }}" alt="">
                    </div>
                    <div class="lonyo-service-data">
                        <p>For users interested in investing, finance apps often provide tools to track stocks, bonds or
                            mutual funds.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="lonyo-service-wrap light-bg" data-aos="fade-up" data-aos-duration="500">
                    <div class="lonyo-service-title">
                        <h4>Tax Management</h4>
                        <img src="{{ asset('frontend/assets/images/v1/feature4.svg') }}" alt="">
                    </div>
                    <div class="lonyo-service-data">
                        <p>This tool integrate with tax software to help users prepare for tax season, deduct expenses,
                            and file returns.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="lonyo-service-wrap light-bg" data-aos="fade-up" data-aos-duration="700">
                    <div class="lonyo-service-title">
                        <h4>Bill Management</h4>
                        <img src="{{ asset('frontend/assets/images/v1/feature5.svg') }}" alt="">
                    </div>
                    <div class="lonyo-service-data">
                        <p>Tracks upcoming bills, sets reminders for due dates, and enables easy payments via
                            integration with online banking</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="lonyo-service-wrap light-bg" data-aos="fade-up" data-aos-duration="900">
                    <div class="lonyo-service-title">
                        <h4>Security Features</h4>
                        <img src="{{ asset('frontend/assets/images/v1/feature6.svg') }}" alt="">
                    </div>
                    <div class="lonyo-service-data">
                        <p>Provides bank-level encryption to ensure user data and financial information remain safe, MFA
                            and biometric logins.</p>
                    </div>
                </div>
            </div>
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
