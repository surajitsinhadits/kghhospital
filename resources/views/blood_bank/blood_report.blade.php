@extends('layouts.structure')

@push('title')
    <title>CAMP - Blood Bag Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('main-content')
    <style>
        body,
        .card,
        .nav-tabs,
        .blood-bag-card {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
        }

        .card_hearder_mimi {
            background: linear-gradient(90deg, #4689b1 0%, 4689b1 100%);
            color: #fff !important;
            border-radius: 0.7rem 0.7rem 0 0;
            padding: 0.7rem 1.5rem;
            box-shadow: 0 2px 8px rgba(70, 137, 177, 0.10);
        }

        .card_hearder_mimi_text {
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 1.2rem;
        }

        .nav-tabs {
            /* border-bottom: none; */
            /* margin-top: 0.7rem; */
            border-bottom: none;
            margin-top: 0.7rem;
            margin-left: 30px;
        }

        .nav-tabs .nav-link {
            color: #b31217;
            font-weight: 600;
            border: none;
            /* border-radius: 0.5rem 0.5rem 0 0; */
            border-radius: 27px;
            background: #f8f9fa;
            margin-right: 0.4rem;
            font-size: 1rem;
            padding: 0.5rem 1.2rem;
            min-width: 90px;
            transition: background 0.18s, color 0.18s;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, #e52d27 0%, #b31217 100%);
            border-bottom: 2px solid #e52d27;
            box-shadow: 0 2px 8px rgba(229, 45, 39, 0.08);
        }

        .badge-live,
        .badge-issued,
        .badge-expired {
            font-size: 0.85rem;
            padding: 0.35em 0.9em;
            border-radius: 1em;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-live {
            background: #e52d27;
            color: #fff;
        }

        .badge-issued {
            background: #17a2b8;
            color: #fff;
        }

        .badge-expired {
            background: #6c757d;
            color: #fff;
        }

        .tab-pane {
            padding-top: 1rem;
        }

        .blood-bag-grid {
            display: flex;
            margin-top: 0.7rem;
        }

        .blood-bag-card {
            border-radius: 1.2rem;
            box-shadow: 0 6px 24px rgba(70, 137, 177, 0.13), 0 1.5px 4px rgba(70, 137, 177, 0.10);
            padding: 1.1rem 0.7rem 1.1rem 0.7rem;
            background: linear-gradient(135deg, #f8fafc 60%, #e3f0fa 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            border: none;
            position: relative;
            min-width: 0;
            min-height: 110px;
            transition: box-shadow 0.18s, border-color 0.18s, transform 0.18s, background 0.18s;
            cursor: pointer;
            overflow: visible;
        }

        .blood-bag-card.available {

            background: linear-gradient(135deg, #e4f9e3 60%, #8afb957a 100%);
            border-top: 4px solid #0a7520;
        }

        .blood-bag-card.issued {
            background: linear-gradient(135deg, #e0f7fa 60%, #f0fcff 100%);
            border-top: 4px solid #17a2b8;
        }

        .blood-bag-card.expired {
            background: linear-gradient(135deg, #ece0e0 60%, #985a5a59 100%);
            border-top: 4px solid #6c757d;
        }

        .blood-bag-card:hover,
        .blood-bag-card:focus {
            box-shadow: 0 12px 32px rgba(70, 137, 177, 0.25), 0 2px 8px rgba(229, 45, 39, 0.08);
            transform: translateY(-6px) scale(1.08);
            background: linear-gradient(135deg, #fffbe7 60%, #e3f0fa 100%);
            z-index: 3;
        }

        .tab-content {
            background: linear-gradient(135deg, #fffbe7 60%, #e3f0fa 100%);
            padding: 0px 10px 0px 10px;
            margin: 15px 9px 0px 9px;
            height: 60vh;
            overflow-y: auto;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        .blood-bag-status {
            position: absolute;
            top: 0.7rem;
            left: 0.7rem;
            padding: 0.18em 0.9em;
            border-radius: 1em;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 1px 4px rgba(70, 137, 177, 0.10);
            background: #fff;
            color: #0a7520;
            border: 1.5px solid #0a7520;
        }

        .blood-bag-card.issued .blood-bag-status {
            color: #17a2b8;
            border-color: #17a2b8;
        }

        .blood-bag-card.expired .blood-bag-status {
            color: #6c757d;
            border-color: #6c757d;
        }

        .barcode-label {
            font-size: 0.95rem;
            color: #888;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
            margin-top: 28px;
            text-align: center;
        }

        .blood-group-badge {
            position: absolute;
            top: 0.7rem;
            right: 0.7rem;
            background: linear-gradient(90deg, #f00 0%, #adb5bd 100%);
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 0.25em 0.8em;
            border-radius: 1.2em;
            box-shadow: 0 1px 4px rgba(70, 137, 177, 0.10);
            letter-spacing: 1px;
        }

        .blood-bag-card.issued .blood-group-badge {
            background: linear-gradient(90deg, #f00 0%, #adb5bd 100%);
        }

        .blood-bag-card.expired .blood-group-badge {
            background: linear-gradient(90deg, #f00 0%, #adb5bd 100%);
            margin-bottom: 8px;
        }

        /* Tooltip style */
        .tooltip-inner {
            max-width: 260px;
            background: #fffbe7;
            color: #333;
            border: 1.5px solid #4689b1;
            border-radius: 0.5rem;
            font-size: 0.88rem;
            text-align: left;
            box-shadow: 0 2px 8px rgba(70, 137, 177, 0.13);
            padding: 0.5rem 0.7rem;
            line-height: 1.3;
        }

        .tooltip.bs-tooltip-top .arrow::before,
        .tooltip.bs-tooltip-auto[x-placement^=top] .arrow::before {
            border-top-color: #4689b1;
        }

        .tooltip-inner b {
            color: #e52d27;
            font-weight: 600;
        }

        .tooltip-inner div:not(:last-child) {
            border-bottom: none;
            margin-bottom: 0.12em;
            padding-bottom: 0.08em;
        }

        .butttonreact {
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            padding: 0.25em 0.8em;
            border-radius: 1.2em;
            box-shadow: 0 1px 4px rgba(70, 137, 177, 0.10);
            letter-spacing: 1px;
            background: #ED213A;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #93291E, #ED213A);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(90deg, #f00 0%, #adb5bd 100%);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

            margin-bottom: 8px;
            border: none;
        }

        .butttonreact.active {
            background: linear-gradient(135deg, #00F260, #0575E6);
            /* Light blue to green */
            color: #000;
        }

        .availableactive {
            background: #56ab2f !important;
            background: -webkit-linear-gradient(to right, #a8e063, #56ab2f) !important;
            background: linear-gradient(to right, #a8e063, #56ab2f) !important;
        }

        .nav-tabs .nav-link span.badge {
            background: transparent !important;
            color: inherit;
        }

        /* ACTIVE TAB COLOR VARIANTS */
        .nav-tabs .nav-link.active#available-tab {
            background: linear-gradient(90deg, #0a7520, #56ab2f);
            color: #fff;
            border-bottom: 2px solid #0a7520;
        }

        .nav-tabs .nav-link.active#issued-tab {
            background: linear-gradient(90deg, #17a2b8 0%, #17a2b8 100%);
            border-bottom: 2px solid #17a2b8;
            color: #fff;
        }

        .nav-tabs .nav-link.active#expired-tab {
            background: linear-gradient(90deg, #e52d27 0%, #b31217 100%);
            border-bottom: 2px solid #e52d27;
            color: #fff;
        }

        /* HOVER EFFECT TO MATCH ACTIVE COLORS */
        .nav-tabs .nav-link#available-tab {
            background: #f0fff4;
            color: #0a7520;
            border: 2px solid #0a7520;
        }

        .nav-tabs .nav-link#issued-tab {
            background: #e8fafd;
            color: #17a2b8;
            border: 2px solid #17a2b8;
        }

        .nav-tabs .nav-link#expired-tab {
            background: #f1f3f5;
            color: #e52d27;
            border: 2px solid #e52d27;
        }

        .nav-tabs .nav-link i {
            margin-right: 6px;
            font-size: 1rem;
            vertical-align: middle;
        }

        .mrtopbutton {
            margin-top: 18px;
        }

        .search-container {
            display: flex;
            align-items: center;

            border-radius: 12px;
            padding: 4px 8px;

            width: fit-content;
            position: relative;
            top: -5px;
        }

        .search-input {
            display: flex;
            align-items: center;
            background: #fffff;
            padding: 1px 16px;
            border-radius: 47px;
            flex: 1;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            border: 2px solid #00000026;
        }

        .search-input i {
            color: #7a8ca3;
            margin-right: 8px;
            font-size: 16px;
        }

        .search-input input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            color: #55657e;
            width: 122px;
            font-weight: 600;
            position: relative;
            top: -2px;
        }

        .search-button {
            background: transparent;
            border: none;
            color: #333;
            font-weight: 500;
            margin-left: 10px;
            cursor: pointer;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .search-button:hover {
            color: #007bff;
        }

        .tabs-and-filters-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 10px 0;
        }

        /* Filter and Search */
        .filters-search-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 17px;
        }

        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .filter-btn {
            padding: 10px;
            border-radius: 20px;
            border: none;
            background-color: #f0f0f0;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-btn.active {
            background-color: #28a7ef;
            color: white;
        }

        @media (max-width: 600px) {
            .blood-bag-grid {
                grid-template-columns: 1fr 1fr;
            }

            .card_hearder_mimi {
                font-size: 0.95rem;
                padding: 0.4rem 0.5rem;
            }
        }
    </style>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text mb-0">
                        <i class="fa fa-tint" aria-hidden="true"></i> Blood Bag Report
                    </h4>
                </div>
                <div class="card-body" style="padding: 0.7rem;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs-and-filters-wrapper">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="bloodTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="available-tab" data-toggle="tab" href="#available"
                                            role="tab" aria-controls="available" aria-selected="true">
                                            <i class="fa fa-check-circle"></i>
                                            <span class="badge badge-live">Available</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="issued-tab" data-toggle="tab" href="#issued" role="tab"
                                            aria-controls="issued" aria-selected="false">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            <span class="badge badge-issued">Issued</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="expired-tab" data-toggle="tab" href="#expired"
                                            role="tab" aria-controls="expired" aria-selected="false">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            <span class="badge badge-expired">Expired</span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- Filters + Search -->
                                <div class="filters-search-group">
                                    <div class="filter-controls" aria-label="Filter items by category">
                                        <button type="button" class="filter-btn active butttonreact" data-filter="all">
                                            <i class="fa-solid fa-droplet"></i> All
                                        </button>
                                        <button type="button" class="filter-btn butttonreact" data-filter="A+">A+</button>
                                        <button type="button" class="filter-btn butttonreact" data-filter="A-">A-</button>
                                        <button type="button" class="filter-btn butttonreact" data-filter="B+">B+</button>
                                        <button type="button" class="filter-btn butttonreact" data-filter="B-">B-</button>
                                        <button type="button" class="filter-btn butttonreact"
                                            data-filter="AB+">AB+</button>
                                        <button type="button" class="filter-btn butttonreact"
                                            data-filter="AB-">AB-</button>
                                        <button type="button" class="filter-btn butttonreact" data-filter="O+">O+</button>
                                        <button type="button" class="filter-btn butttonreact" data-filter="O-">O-</button>
                                    </div>

                                    <div class="search-container">
                                        <div class="search-input">
                                            <i class="fas fa-search"></i>
                                            <input type="text" placeholder="Search Here" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="tab-content pt-2" id="bloodTabContent">
                        <!-- Available Blood -->
                        <div class="tab-pane fade show active" id="available" role="tabpanel"
                            aria-labelledby="available-tab">
                            <div class="blood-bag-grid" id="available-bag-grid">
                                <div class="text-center w-100" id="available-loading">
                                    <i class="fa fa-spinner fa-spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                        <!-- Issued Blood -->
                        <div class="tab-pane fade" id="issued" role="tabpanel" aria-labelledby="issued-tab">
                            <div class="blood-bag-grid row" id="issued-bag-grid">
                                <div class="text-center w-100" id="issued-loading">
                                    <i class="fa fa-spinner fa-spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                        <!-- Expired Blood -->
                        <div class="tab-pane fade" id="expired" role="tabpanel" aria-labelledby="expired-tab">
                            {{-- Line Chart for Expired Blood --}}
                            {{-- <div class="mb-4">
                                <div id="expired-blood-line-chart" style="width:100%; min-height:320px; background:#fff; border-radius:1rem; box-shadow:0 2px 8px #0001; padding:1rem;"></div>
                            </div> --}}
                            <div class="blood" style="display: flex;  gap: 10px;  justify-content: center;">

                            </div>
                            <div class="blood-bag-grid row" id="expired-bag-grid">
                                <div class="text-center w-100" id="expired-loading">
                                    <i class="fa fa-spinner fa-spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div> <!-- tab-content -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        (function() {
            const transitionDuration = 400; // ms, should match your CSS

            // Add CSS for animation if not present
            if (!document.getElementById('blood-bag-filter-anim-style')) {
                const style = document.createElement('style');
                style.id = 'blood-bag-filter-anim-style';
                style.innerHTML = `
            .blood-bag-item {
                transition: opacity ${transitionDuration}ms;
                opacity: 1;
                display: block;
            }
            .blood-bag-item.hidden {
                opacity: 0;
            }
        `;
                document.head.appendChild(style);
            }

            function filterGrid($filterBtn) {
                const filterValue = $filterBtn.getAttribute('data-filter');
                // Find the closest tab-pane (or fallback to active)
                let tabPane = $filterBtn.closest('.tab-pane');
                if (!tabPane) tabPane = document.querySelector('.tab-pane.active.show');
                if (!tabPane) return;
                const gridItems = tabPane.querySelectorAll('.blood-bag-item');

                gridItems.forEach((item) => {
                    const itemCategory = (item.getAttribute('data-category') || '').trim();
                    const shouldShow = filterValue === 'all' || itemCategory === filterValue;
                    const isHidden = item.classList.contains('hidden');

                    if (shouldShow) {
                        if (isHidden) {
                            item.style.display = '';
                            // Force reflow for transition
                            void item.offsetWidth;
                            item.classList.remove('hidden');
                        }
                    } else {
                        if (!isHidden) {
                            item.classList.add('hidden');
                            setTimeout(() => {
                                if (item.classList.contains('hidden')) {
                                    item.style.display = 'none';
                                }
                            }, transitionDuration);
                        }
                    }
                });
            }

            function handleFilterClick(e) {
                const $btn = e.currentTarget;
                // Remove active from all in this filter-controls
                const filterControls = $btn.closest('.filter-controls');
                filterControls.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-pressed', 'false');
                });
                $btn.classList.add('active');
                $btn.setAttribute('aria-pressed', 'true');
                filterGrid($btn);
            }

            // Initialization function (call after AJAX loads grid)
            window.initBloodBagFilter = function() {
                // Remove previous listeners to avoid duplicates
                document.querySelectorAll('.filter-controls .filter-btn').forEach(btn => {
                    btn.removeEventListener('click', handleFilterClick);
                    btn.addEventListener('click', handleFilterClick);
                });
            };

            // Run on DOMContentLoaded
            document.addEventListener('DOMContentLoaded', () => {
                window.initBloodBagFilter();
            });

            // Optionally, re-apply filter after AJAX grid update
            window.reapplyActiveFilterWithAnimation = function(tabId) {
                const tabPane = document.getElementById(tabId);
                if (!tabPane) return;
                const activeBtn = tabPane.querySelector('.filter-btn.active');
                if (activeBtn) filterGrid(activeBtn);
            };
        })();

        // Optionally, after AJAX loads new data, reapply the filter:
        function reapplyActiveFilter(tabId) {
            var $tabPane = $('#' + tabId);
            var $activeBtn = $tabPane.find('.filter-btn.active');
            if ($activeBtn.length) {
                var filter = $activeBtn.data('filter');
                var $grid = $tabPane.find('.blood-bag-item');
                $grid.each(function() {
                    var category = $(this).data('category');
                    if (filter === 'all' || category === filter) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        }


        function formatResult(result) {
            if (result === 'Negative') return 'N';
            if (result === 'Positive') return 'P';
            return result ?? '';
        }

        function bagTooltipContent(bag, type) {
            let html = ``;
            if (type === 'available' || type === 'expired') {
                html += `
                    <div><b>NAT:</b> ${formatResult(bag.nat_result)} || <b>ELISA:</b> ${formatResult(bag.elisa_result)}</div>
                    <div><b>HIV:</b> ${formatResult(bag.hiv_result)} || <b>HbsAg:</b> ${formatResult(bag.hbsag_result)}</div>
                    <div><b>HCV:</b> ${formatResult(bag.hcv_result)} || <b>Syphilis:</b> ${formatResult(bag.syphilis_result)}</div>
                    <div><b>Syphilis:</b> ${formatResult(bag.syphilis_result)} || <b>Malaria:</b> ${formatResult(bag.malaria_result)}</div>
                    <div><b>Crossmatch:</b> ${formatResult(bag.crossmatch_result)}</div>`;
            }
            if (type === 'issued') {
                html += `<div><b>Issued To:</b> ${bag.issued_to ?? ''}</div>
                    <div><b>Issue Date:</b> ${bag.issue_date ?? ''}</div>
                    <div><b>Blood Group:</b> ${bag.blood_group ?? ''}</div>
                    <div><b>Component:</b> ${bag.component ?? ''}</div>`;
            }
            return html;
        }

        function renderAvailableBags(data) {
            if (!data.data || data.data.length === 0) {
                return '<div class="text-center w-100" style="font-size:0.95rem;">No available blood bags found.</div>';
            }
            let html = '';
            data.data.forEach(function(bag) {
                html += `<div class="col-md-2 mb-2 blood-bag-item" data-category="${bag.blood_group ?? ''}"><div class="blood-bag-card available" tabindex="0"
            data-toggle="tooltip" data-html="true" title="${bagTooltipContent(bag, 'available').replace(/"/g, '&quot;')}">
            <span class="blood-bag-status available"><i class="fa fa-check-circle"></i> Available</span>
            <span class="blood-group-badge">${bag.blood_group ?? ''}</span>
            <div class="barcode-label">Bag Barcode</div>
            <div class="blood-bag-title">${bag.bag_barcode ?? ''}</div>
        </div></div>`;
            });
            return html;
        }

        function renderIssuedBags(data) {
            if (!data.data || data.data.length === 0) {
                return '<div class="text-center w-100" style="font-size:0.95rem;">No issued blood bags found.</div>';
            }
            let html = '';
            data.data.forEach(function(bag) {
                html += `<div class="col-md-2 mb-2 blood-bag-item" data-category="${bag.blood_group ?? ''}"><div class="blood-bag-card issued"  tabindex="0"
            data-toggle="tooltip" data-html="true" title="${bagTooltipContent(bag, 'issued').replace(/"/g, '&quot;')}">
            <span class="blood-bag-status issued"><i class="fa fa-sign-out"></i> Issued</span>
            <span class="blood-group-badge">${bag.blood_group ?? ''}</span>
            <div class="barcode-label">Bag Barcode</div>
            <div class="blood-bag-title">${bag.bag_barcode ?? ''}</div>
        </div></div>`;
            });
            return html;
        }

        // function renderExpiredBags(data) {
        //     if (!data.data || data.data.length === 0) {
        //         return '<div class="text-center w-100" style="font-size:0.95rem;">No expired blood bags found.</div>';
        //     }
        //     let html = '';
        //     data.data.forEach(function(bag) {
        //         html += `<div class="col-md-2 mb-2"><div class="blood-bag-card expired" tabindex="0"
    //             data-toggle="tooltip" data-html="true" title="${bagTooltipContent(bag, 'expired').replace(/"/g, '&quot;')}">
    //             <span class="blood-bag-status expired"><i class="fa fa-clock-o"></i> Expired</span>
    //             <span class="blood-group-badge">${bag.blood_group ?? ''}</span>
    //             <div class="barcode-label">Bag Barcode</div>
    //             <div class="blood-bag-title">${bag.bag_barcode ?? ''}</div>
    //         </div></div>`;
        //     });
        //     return html;
        // }

        function renderExpiredBags(data) {
            if (!data.data || data.data.length === 0) {
                return '<div class="text-center w-100" style="font-size:0.95rem;">No expired blood bags found.</div>';
            }
            let html = '';
            data.data.forEach(function(bag) {
                html += `<div class="col-md-2 mb-2 blood-bag-item" data-category="${bag.blood_group ?? ''}"><div class="blood-bag-card expired" tabindex="0"
                data-toggle="tooltip" data-html="true" title="${bagTooltipContent(bag, 'expired').replace(/"/g, '&quot;')}">
                <span class="blood-bag-status expired"><i class="fa fa-clock-o"></i> Expired</span>
                <span class="blood-group-badge">${bag.blood_group ?? ''}</span>
                <div class="barcode-label">Bag Barcode</div>
                <div class="blood-bag-title">${bag.bag_barcode ?? ''}</div>
                    </div></div>`;
            });
            return html;
        }

        function fetchAndRenderBags(type) {
            let url = '';
            let gridId = '';
            if (type === 'available') {
                url = "{{ route('bl.available-blood') }}";
                gridId = '#available-bag-grid';
            } else if (type === 'issued') {
                url = "{{ route('bl.issued-blood') }}";
                gridId = '#issued-bag-grid';
            } else if (type === 'expired') {
                url = "{{ route('bl.expired-blood') }}";
                gridId = '#expired-bag-grid';
            }
            $(gridId).html('<div class="text-center w-100"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let html = '';
                    if (type === 'available') {
                        html = renderAvailableBags(data);
                    } else if (type === 'issued') {
                        html = renderIssuedBags(data);
                    } else if (type === 'expired') {
                        html = renderExpiredBags(data);
                        // Also update the expired blood chart
                        // updateExpiredBloodChart(data);
                    }
                    $(gridId).html(html);
                    $(gridId + ' [data-toggle="tooltip"]').tooltip({
                        container: 'body',
                        trigger: 'hover focus'
                    });
                },
                error: function() {
                    $(gridId).html(
                        '<div class="text-center w-100 text-danger" style="font-size:0.95rem;">Failed to load data.</div>'
                    );
                }
            });
        }

        // ApexCharts for expired blood
        function updateExpiredBloodChart(data) {
            // Always show last 30 days as x-axis
            let today = new Date();
            let labels = [];
            let dateMap = {};
            for (let i = 29; i >= 0; i--) {
                let dt = new Date(today.getFullYear(), today.getMonth(), today.getDate() - i);
                let key = dt.toISOString().slice(0, 10);
                labels.push(key);
                dateMap[key] = 0;
            }

            // Count expired bags per date
            (data.data || []).forEach(function(bag) {
                let exp = bag.expiry_date;
                if (exp) {
                    let key = exp.slice(0, 10);
                    if (key in dateMap) {
                        dateMap[key]++;
                    }
                }
            });

            let seriesData = labels.map(date => dateMap[date]);

            var options = {
                chart: {
                    type: 'line',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Expired Blood Bags',
                    data: seriesData
                }],
                xaxis: {
                    categories: labels,
                    title: {
                        text: 'Expiry Date'
                    },
                    labels: {
                        rotate: -45,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Count'
                    },
                    min: 0,
                    forceNiceScale: true
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5,
                    colors: ['#e52d27'],
                    strokeColors: '#fff',
                    strokeWidth: 2
                },
                colors: ['#e52d27'],
                grid: {
                    borderColor: '#eee'
                },
                tooltip: {
                    x: {
                        format: 'yyyy-MM-dd'
                    }
                }
            };

            if (window.expiredBloodChart) {
                window.expiredBloodChart.updateOptions(options);
            } else {
                window.expiredBloodChart = new ApexCharts(document.querySelector("#expired-blood-line-chart"), options);
                window.expiredBloodChart.render();
            }
        }

        $(document).ready(function() {
            fetchAndRenderBags('available');
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href");
                if (target === "#available") {
                    fetchAndRenderBags('available');
                } else if (target === "#issued") {
                    fetchAndRenderBags('issued');
                } else if (target === "#expired") {
                    fetchAndRenderBags('expired');
                }
            });
            // If expired tab is default, load chart
            if ($('#expired').hasClass('show active')) {
                fetchAndRenderBags('expired');
            }
        });
    </script>
@endpush
