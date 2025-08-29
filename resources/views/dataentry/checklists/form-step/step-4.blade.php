<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"> जीवनाशक विषादीको चेकलिष्ट विवरण</h4>

                @if ($checklist->Status == 0)
                    <form action="{{ route('dataentry.checklists.create-formulation', [$checklist->id, 'step=4']) }}"
                        method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="common_name_id" class="form-label">जीवनाशक विषादीको साधारण नाम</label>
                                <select class="form-control @error('common_name_id') is-invalid @enderror"
                                    id="common_name_id" name="common_name_id" required>
                                    <option value="" disabled selected>कमन नाम छान्नुहोस्</option>
                                    @foreach ($commonNames as $common)
                                        <option value="{{ $common->id }}"
                                            {{ old('common_name_id') == $common->id ? 'selected' : '' }}>
                                            {{ $common->common_name }}</option>
                                    @endforeach
                                </select>
                                @error('common_name_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="ActiveIngredientValue" class="form-label">सक्रिय अंश</label>
                                <input type="text"
                                    class="form-control @error('ActiveIngredientValue') is-invalid @enderror"
                                    id="ActiveIngredientValue" name="ActiveIngredientValue"
                                    value="{{ old('ActiveIngredientValue') }}" required>
                                @error('ActiveIngredientValue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="unit_id" class="form-label">युनिट</label>
                                <select class="form-control @error('unit_id') is-invalid @enderror" id="unit_id"
                                    name="unit_id" required>
                                    <option value="" disabled selected>युनिट छान्नुहोस्</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->unit_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
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
                                    <th width="30%">कमन नाम</th>
                                    <th width="30%">फर्मुलेसन</th>
                                    <th width="20%">Active Ingredient Value</th>
                                    <th width="20%">युनिट</th>
                                    <th width="5%"></th>
                                </tr>
                                @foreach ($checklist->check_list_formulations as $clFormulations)
                                    <tr>
                                        <td>{{ $clFormulations->common_name->common_name }}</td>
                                        <td>{{ $clFormulations->formulation->formulation_name }}</td>
                                        <td>{{ $clFormulations->ActiveIngredientValue }}</td>
                                        <td>{{ $clFormulations->unit->unit_name }}</td>
                                        <td align="center">
                                            @if ($checklist->Status == 0)
                                                <form
                                                    action="{{ route('dataentry.checklists.destroy-formulation', [$checklist, $clFormulations->id, 'step=4']) }}"
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
                                    </tr>
                                @endforeach
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
        <a href="{{ route('dataentry.checklists.follow-steps', [$checklist->id, 'step=3']) }}"
            class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('dataentry.checklists.show', $checklist) }}"
            class="float-end btn btn-primary">
            अगाडी बढ्ने <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>
