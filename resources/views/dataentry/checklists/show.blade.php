@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">पेश गर्ने व्यक्ति, संस्था वा निकायको विवरण</h4>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="20%">पेश गर्ने व्यक्ति, संस्था वा निकायकोको नाम:</th>
                                        <td width="30%">{{ $checklist->ImporterName }}</td>
                                        <th width="10%">इजाजतपत्र नं.:</th>
                                        <td width="20%">{{ $checklist->LicenseNo }}</td>
                                    </tr>
                                    <tr>
                                        <th>आवेदनको प्रकार:</th>
                                        <td>{{ checklistType($checklist->ApplicationType) }}</td>
                                        <th>स्थिति:</th>
                                        <td>{!! checklistStatus($checklist->Status) !!}</td>
                                    </tr>

                                    @if ($checklist->CreatedBy)
                                        <tr>
                                            <th>दर्ता गर्ने:</th>
                                            <td colspan="3">
                                                {{ $checklist->creator->name }} <br>
                                                मितिः {{ $checklist->CreatedDateNepali }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($checklist->VerifiedBY)
                                        <tr>
                                            <th>प्रमाणित गर्ने:</th>
                                            <td colspan="3">
                                                {{ $checklist->verifier->name }} <br>
                                                मितिः {{ $checklist->VerifiedDateNepali }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($checklist->ApprovedBy)
                                        <tr>
                                            <th>स्वीकृत गर्ने:</th>
                                            <td colspan="3">
                                                {{ $checklist->approver->name }} <br>
                                                मितिः {{ $checklist->ApprovedDateNepali }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th> जीवनाशक विषादीको साधारण नाम</th>
                                        <td> {{ $checklist->TradeNameOfPesticide }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-12">
                            <h4 class="card-title">चेकलिष्ट कन्टेनर विवरण</h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="50%">कन्टेनर</th>
                                        <td width="20%">क्षमता</td>
                                        <th width="20%">युनिट</th>
                                    </tr>
                                    @foreach ($checklist->check_list_containers as $clContainers)
                                        <tr>
                                            <td>{{ $clContainers->container->container_name }}</td>
                                            <td>{{ $clContainers->capacity }}</td>
                                            <td>{{ $clContainers->unit->unit_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">

                            <h4 class="card-title">उत्पादनकर्ताको विवरण</h4>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%">उत्पादकको नाम</th>
                                        <th width="30%">ठेगाना</th>
                                        <th width="20%">देश</th>
                                        <th width="20%">पञ्जिकरण नं.</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $checklist->NameofProducer }}</td>
                                        <td>{{ $checklist->Address }}</td>
                                        <td>{{ $checklist->country->country_name }}</td>
                                        <td>{{ $checklist->ProducerCountryPanjikaranNo }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">चेकलिष्ट फर्मुलेसन विवरण</h4>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%">कमन नाम</th>
                                        <th width="30%">फर्मुलेसन</th>
                                        <th width="20%">Active Ingredient Value</th>
                                        <th width="20%">युनिट</th>
                                    </tr>
                                    @foreach ($checklist->check_list_formulations as $clFormulations)
                                        <tr>
                                            <td>{{ $clFormulations->common_name->common_name }}</td>
                                            <td>{{ $clFormulations->formulation->formulation_name }}</td>
                                            <td>{{ $clFormulations->ActiveIngredientValue }}</td>
                                            <td>{{ $clFormulations->unit->unit_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">NNSW रिसिप्ट मिति विवरण</h4>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%">Date of Receipt in NNSW Nep </th>
                                        <th width="30%">Container and Nepali Text Receipt Date </th>
                                    </tr>
                                    <tr>
                                        <td>{{ $checklist->DateOfReceiptInNNSWNep }}</td>
                                        <td>{{ $checklist->ContainerReceiptDate }}</td>
                                    </tr>
                                </tbody>
                            </table>
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
                            <a href="{{ route('dataentry.checklists.details.index', $checklist->id) }}"
                                class="float-end btn btn-primary">
                                अगाडी बढ्ने <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
