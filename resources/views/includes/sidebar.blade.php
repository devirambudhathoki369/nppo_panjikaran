<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!-- Side menu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">मेनु</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="mdi mdi-desktop-mac-dashboard"></i>
                        <span data-key="t-dashboard">ड्यासबोर्ड</span>
                    </a>
                </li>

                @if (auth()->user()->usertype === 'admin')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="mdi mdi-cookie-settings"></i>
                            <span data-key="t-apps"> आधारभुत विवरण </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('users.index') }}">
                                    <span data-key="t-users"> प्रयोगकर्ता व्यवस्थापन</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('checklist-points.index') }}">
                                    <span data-key="t-users"> चेकलिष्टका बुँदा प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('countries.index') }}">
                                    <span data-key="t-users"> देशको विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('containers.index') }}">
                                    <span data-key="t-users"> कन्टेनरको विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('units.index') }}">
                                    <span data-key="t-users"> युनिट विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('common-names.index') }}">
                                    <span data-key="t-users"> कमन नाम विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('formulations.index') }}">
                                    <span data-key="t-users"> फर्मुलेसन विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bishadi-types.index') }}">
                                    <span data-key="t-bishadi-types">बिषादिको प्रकार विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('sources.index') }}">
                                    <span data-key="t-bishadi-types">स्रोतको विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('objectives.index') }}">
                                    <span data-key="t-bishadi-types">उद्देश्यको विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('usages.index') }}">
                                    <span data-key="t-usage-types">उपयोगको विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('crops.index') }}">
                                    <span data-key="t-crop-types">बालीको विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pests.index') }}">
                                    <span data-key="t-pest-types">कीराको विवरण प्रविष्टि</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('packagedestroys.index') }}">
                                    <span data-key="t-packagedestroy-types">प्याकेज नष्ट विधिको विवरण प्रविष्टि</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{ route('dataentry.checklists.index') }}">
                        <i class="mdi mdi-format-list-checks"></i>
                        <span data-key="t-apps"> चेकलिष्ट प्रविष्टि </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('checklists.index') }}">
                        <i class="mdi mdi-clipboard-text"></i>
                        <span data-key="t-apps"> पञ्जीकरण प्रविष्टि </span>
                    </a>
                </li>

                <!-- Reports Section -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="mdi mdi-chart-line"></i>
                        <span data-key="t-reports"> रिपोर्टहरू </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('dataentry.checklists.reports') }}">
                                <i class="mdi mdi-file-document"></i>
                                <span data-key="t-checklist-reports"> चेकलिष्ट रिपोर्ट</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('panjikarans.reports') }}">
                                <i class="mdi mdi-file-chart"></i>
                                <span data-key="t-panjikaran-reports"> पञ्जीकरण रिपोर्ट</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Database Backup Section -->
                @if (auth()->user()->usertype === 'admin')
                    <li>
                        <a style="color:white">
                            <form action="{{ route('database.backup.download') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-link p-0" style="text-decoration:none;">
                                    <i class="mdi mdi-database-export"></i>
                                    <span data-key="t-backup" style="color: white"> डेटाबेस ब्याकअप </span>
                                </button>
                            </form>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
