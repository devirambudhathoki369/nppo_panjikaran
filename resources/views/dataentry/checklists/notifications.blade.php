@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">सूचनाहरू</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dataentry.checklists.index') }}">चेकलिष्ट</a></li>
                        <li class="breadcrumb-item active">सूचनाहरू</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if ($notifications->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">कुनै सूचना छैन</h5>
                            <p class="text-muted">तपाईंका लागि कुनै नयाँ सूचना छैन।</p>
                            <a href="{{ route('dataentry.checklists.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> चेकलिष्टमा फर्किनुहोस्
                            </a>
                        </div>
                    @else
                        <div class="notification-list">
                            @foreach ($notifications as $notification)
                                <div
                                    class="notification-item {{ $notification->status == 'unread' ? 'unread' : '' }} mb-3 p-3 border rounded">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    @if ($notification->action_type == 'send_back')
                                                        <i class="fas fa-arrow-left text-danger fa-lg"></i>
                                                    @elseif($notification->action_type == 'send_to_verify')
                                                        <i class="fas fa-paper-plane text-warning fa-lg"></i>
                                                    @else
                                                        <i class="fas fa-bell text-info fa-lg"></i>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">
                                                        <a href="{{ route('dataentry.checklists.show', $notification->checklist->id) }}"
                                                            class="text-decoration-none">
                                                            {{ $notification->checklist->ImporterName }}
                                                        </a>
                                                        @if ($notification->status == 'unread')
                                                            <span class="badge bg-primary ms-2">नयाँ</span>
                                                        @endif
                                                    </h6>
                                                    <p class="mb-1 text-muted small">
                                                        {{ $notification->fromUser->name }} द्वारा
                                                        @if ($notification->action_type == 'send_back')
                                                            फिर्ता पठाइयो
                                                        @elseif($notification->action_type == 'send_to_verify')
                                                            सिफारीसको लागि पठाइयो
                                                        @else
                                                            सूचना पठाइयो
                                                        @endif
                                                    </p>
                                                    @if ($notification->comment)
                                                        <div class="comment-box bg-light p-2 rounded mt-2">
                                                            <strong>टिप्पणी:</strong>
                                                            <p class="mb-0 mt-1">{{ $notification->comment }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <small
                                                class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            <br>
                                            <small
                                                class="text-muted">{{ $notification->created_at->format('Y-m-d H:i') }}</small>
                                            <div class="mt-2">
                                                <a href="{{ route('dataentry.checklists.show', $notification->checklist->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> हेर्नुहोस्
                                                </a>
                                                @if ($notification->status == 'unread')
                                                    <a href="{{ route('dataentry.checklists.mark-notification-read', $notification->id) }}"
                                                        class="btn btn-sm btn-outline-success ms-1">
                                                        <i class="fas fa-check"></i> पढियो
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pagination-wrap hstack gap-2 justify-content-center">
                                    {{ $notifications->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .notification-item.unread {
            background-color: #f8f9ff;
            border-left: 4px solid #007bff;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .comment-box {
            border-left: 3px solid #dee2e6;
        }

        .notification-item.unread .comment-box {
            border-left-color: #007bff;
        }
    </style>
@endsection
