<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">उत्पादनकर्ताको विवरण</h4>

        @if($checklist->Status == 0 && !$checklist->NameofProducer)
        <form action="{{ route('dataentry.checklists.update-producer', [$checklist->id, 'step=3']) }}" method="POST">
          @csrf
          <div class="row">

            <div class="col-md-4 mb-3">
              <label for="NameofProducer" class="form-label">उत्पादकको नाम</label>
              <input type="text" class="form-control @error('NameofProducer') is-invalid @enderror"
                id="NameofProducer" name="NameofProducer" value="{{ old('NameofProducer') }}" required>
              @error('NameofProducer')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4 mb-3">
              <label for="Address" class="form-label">ठेगाना</label>
              <input type="text" class="form-control @error('Address') is-invalid @enderror"
                id="Address" name="Address" value="{{ old('Address') }}" required>
              @error('Address')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-2 mb-3">
              <label for="CountryID" class="form-label">देशको विवरण विवरण</label>
              <select class="form-control @error('CountryID') is-invalid @enderror"
                id="CountryID" name="CountryID" required>
                <option value="" disabled selected>देशको विवरण छान्नुहोस्</option>
                @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ old('CountryID') == $country->id ? 'selected' : '' }}>{{ $country->country_name }}</option>
                @endforeach
              </select>
              @error('CountryID')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-2 mb-3">
              <label for="ProducerCountryPanjikaranNo" class="form-label">पञ्जिकरण नं.</label>
              <input type="text" class="form-control @error('ProducerCountryPanjikaranNo') is-invalid @enderror"
                id="ProducerCountryPanjikaranNo" name="ProducerCountryPanjikaranNo" value="{{ old('ProducerCountryPanjikaranNo') }}" required>
              @error('ProducerCountryPanjikaranNo')
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
                  <th width="30%">उत्पादकको नाम</th>
                  <th width="30%">ठेगाना</th>
                  <th width="20%">देश</th>
                  <th width="20%">पञ्जिकरण नं.</th>
                  <th width="5%"></th>
                </tr>
                <tr>
                  @if($checklist->NameofProducer)
                  <td>{{ $checklist->NameofProducer }}</td>
                  <td>{{ $checklist->Address }}</td>
                  <td>{{ $checklist->country->country_name }}</td>
                  <td>{{ $checklist->ProducerCountryPanjikaranNo }}</td>
                  <td align="center">
                    @if($checklist->Status == 0)
                    <form action="{{ route('dataentry.checklists.remove-producer', [$checklist, 'step=3']) }}"
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
    <a href="{{ route('dataentry.checklists.follow-steps', [$checklist->id, 'step=2']) }}" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
    </a>
  </div>
  <div class="col-md-6">
    <a href="{{ route('dataentry.checklists.follow-steps', [$checklist->id, 'step=4']) }}" class="float-end btn btn-primary">
      अगाडी बढ्ने <i class="fa fa-arrow-right"></i>
    </a>
  </div>
</div>