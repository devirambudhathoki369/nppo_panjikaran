<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">NNSW रिसिप्ट मिति विवरण</h4>

                @if ($checklist->Status == 0 && (!$checklist->DateOfReceiptInNNSWNep || !$checklist->ContainerReceiptDate))
                    <form action="{{ route('dataentry.checklists.update-receipt-date', [$checklist->id, 'step=5']) }}"
                        method="POST">
                        @csrf
                        <div class="row justify-content-center">

                            <div class="col-md-4 mb-3">
                                <label for="DateOfReceiptInNNSWNep" class="form-label">नेपाल राष्ट्रिय एकद्वार प्रणालीमा प्राप्त मिति</label>
                                <input type="date"
                                    class="form-control @error('DateOfReceiptInNNSWNep') is-invalid @enderror"
                                    id="DateOfReceiptInNNSWNep" name="DateOfReceiptInNNSWNep"
                                    value="{{ old('DateOfReceiptInNNSWNep') }}" required>
                                @error('DateOfReceiptInNNSWNep')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ContainerReceiptDate" class="form-label">सूचक पत्र, कन्टेनर र नेपाली भाषामा लेखिएको विवरण प्राप्त मिति</label>
                                <input type="date"
                                    class="form-control @error('ContainerReceiptDate') is-invalid @enderror"
                                    id="ContainerReceiptDate" name="ContainerReceiptDate"
                                    value="{{ old('ContainerReceiptDate') }}" required>
                                @error('ContainerReceiptDate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa fa-save"></i> सेभ गर्नुहोस्
                                </button>
                            </div>
                        </div>
                    </form>
                @endif

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">नेपाल राष्ट्रिय एकद्वार प्रणालीमा प्राप्त मिति</th>
                                    <th width="30%">सूचक पत्र, कन्टेनर र नेपाली भाषामा लेखिएको विवरण प्राप्त मिति</th>
                                    <th width="5%"></th>
                                </tr>
                                <tr>
                                    @if ($checklist->DateOfReceiptInNNSWNep)
                                        <td>{{ $checklist->DateOfReceiptInNNSWNep }}</td>
                                        <td>{{ $checklist->ContainerReceiptDate }}</td>
                                        <td align="center">
                                            @if ($checklist->Status == 0)
                                                <form
                                                    action="{{ route('dataentry.checklists.remove-receipt-date', [$checklist, 'step=5']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger"
                                                        onclick="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')"
                                                        title="मेट्नुहोस्">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @else
                                        <td colspan="5"></td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3 justify-between">
    <div class="col-md-6">
        <a href="{{ route('dataentry.checklists.follow-steps', [$checklist->id, 'step=4']) }}"
            class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('dataentry.checklists.show', $checklist) }}" class="float-end btn btn-primary">
            अगाडी बढ्ने <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>
