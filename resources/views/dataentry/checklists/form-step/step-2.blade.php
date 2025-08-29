<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">चेकलिष्ट कन्टेनर विवरण</h4>

        @if($checklist->Status == 0)
        <form action="{{ route('dataentry.checklists.create-container', [$checklist->id, 'step=2']) }}" method="POST">
          @csrf
          <div class="row">

            <div class="col-md-3 mb-3">
              <label for="container_id" class="form-label">कन्टेनर विवरण</label>
              <select class="form-control @error('container_id') is-invalid @enderror"
                id="container_id" name="container_id" required>
                <option value="" disabled selected>कन्टेनर छान्नुहोस्</option>
                @foreach($containers as $container)
                <option value="{{ $container->id }}" {{ old('container_id') == $container->id ? 'selected' : '' }}>{{ $container->container_name }}</option>
                @endforeach
              </select>
              @error('container_id')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-3 mb-3">
              <label for="capacity" class="form-label">क्षमता</label>
              <input type="text" class="form-control @error('capacity') is-invalid @enderror"
                id="capacity" name="capacity" value="{{ old('capacity') }}" required>
              @error('capacity')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-3 mb-3">
              <label for="unit_id" class="form-label">युनिट</label>
              <select class="form-control @error('unit_id') is-invalid @enderror"
                id="unit_id" name="unit_id" required>
                <option value="" disabled selected>युनिट छान्नुहोस्</option>
                @foreach($units as $unit)
                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
                @endforeach
              </select>
              @error('unit_id')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-3">
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
                  <th width="50%">कन्टेनर</th>
                  <td width="20%">क्षमता</td>
                  <th width="20%">युनिट</th>
                  <td width="5%"></td>
                </tr>
                @foreach($checklist->check_list_containers as $clContainers)
                <tr>
                  <td>{{ $clContainers->container->container_name }}</td>
                  <td>{{ $clContainers->capacity }}</td>
                  <td>{{ $clContainers->unit->unit_name }}</td>
                  <td align="center">
                    @if($checklist->Status == 0)
                    <form action="{{ route('dataentry.checklists.destroy-container', [$checklist, $clContainers->id, 'step=2']) }}"
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
    <a href="{{ route('dataentry.checklists.index') }}" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
    </a>
  </div>
  <div class="col-md-6">
    <a href="{{ route('dataentry.checklists.follow-steps', [$checklist->id, 'step=3']) }}" class="float-end btn btn-primary">
      अगाडी बढ्ने <i class="fa fa-arrow-right"></i>
    </a>
  </div>
</div>