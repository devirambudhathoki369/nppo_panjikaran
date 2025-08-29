@if ($errors->any())
    <div class="row mb-2">
        <div class="col">
            <div class="alert alert-danger">
                <ul class="mb-0">
                    {!! implode('', $errors->all('<li>:message</li>')) !!}
                </ul>
            </div>
        </div>
    </div>
@endif

@if (session('primary'))
    <div class="custom-alert alert alert-primary alert-border-left animated flipInX alert-dismissible fade show"
        role="alert">
        <i class="ri-user-smile-line align-left"></i> <strong>Message !</strong> {!! session('primary') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('secondary'))
    <div class="custom-alert alert alert-secondary alert-border-left animated flipInX alert-dismissible fade show"
        role="alert">
        <i class="ri-check-double-line align-left"></i> <strong>Message !</strong> {!! session('secondary') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('success'))
    <div class="custom-alert alert alert-success alert-border-left animated flipInX alert-dismissible fade show"
        role="alert">
        <i class="ri-check-line align-left"></i> <strong>Message !</strong> {!! session('success') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="custom-alert alert alert-danger alert-border-left animated flipInX alert-dismissible fade show"
        role="alert">
        <i class="ri-danger-warning-line align-left"></i> <strong>Message !</strong> {!! session('error') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('warning'))
    <div class="custom-alert alert alert-warning alert-border-left animated flipInX alert-dismissible fade show"
        role="alert">
        <i class="ri-alert-line align-left"></i> <strong>Message !</strong> {!! session('warning') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('info'))
    <div class="custom-alert alert alert-info alert-border-left animated flipInX alert-dismissible fade show"
        role="alert">
        <i class="ri-airplay-line align-left"></i> <strong>Message !</strong> {!! session('info') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
