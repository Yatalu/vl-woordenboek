@extends ('layouts.application-blank', ['title' => $word->word])

@section ('openGraph')
    <meta property="og:title" content="{{ $word->word }} - {{ config('app.name', 'Laravel') }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ request()->fullUrl() }}"/>
    <meta property="og:description" content="{{ $word->seo_description }}"/>
    <meta property="og:image" content="{{ asset('/img/app-logo.jpg') }}"/>
    <meta property="og:image:alt" content="Logo van het Vlaams woordenboek"/>
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}"/>
    <meta property="article:published_time" content="{{ optional($word->published_at)->toIso8601String() ?? \Illuminate\Support\Carbon::parse($word->created_at)->toIso8601String() }}"/>
    <meta property="article:modified_time" content="{{ optional($word->updated_at)->toIso8601String() ?? \Illuminate\Support\Carbon::now()->toIso8601String() }}"/>
    <meta property="og:article:author" content="{{ $word->editor->name ?? '' }}"/>
    <meta property="og:section" content="Linguïstiek"/>

    @if ($word->isArchived())
        <meta name="robots" content="noindex, follow" />
    @endif
@endsection

@section ('content')
    <style>
        .markdown-text p:not(:last-child) { margin-bottom: .70rem; }
    </style>

    <x-definitions.admin-management-nav :word=$word :articleResource=$articleResource/>


    <div class="word-header py-5 border-bottom bg-light">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><x-heroicon-o-home class="icon me-1"/>Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $word->word }}</li>
                            </ol>
                        </nav>
                        <a href="{{ url()->previous() }}" class="back-link">
                            <x-heroicon-o-arrow-left style="width:1rem"/>
                            Terug naar vorige pagina
                        </a>
                    </div>

                    <h1 class="display-3 fw-bold mb-1">{{ $word->word }}</h1>

                    <div class="d-flex flex-column gap-2">
                        @if($word->regions->isNotEmpty())
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                @foreach($word->regions as $region)
                                    <a href="{{ route('region:show', $region) }}"
                                       class="text-decoration-none d-flex align-items-center text-uppercase"
                                       style="font-size: 0.75rem; font-weight: 700; color: var(--lexi-region-text); letter-spacing: 0.025em;">
                                        <x-heroicon-s-map-pin style="width:0.9rem; margin-right: 0.2rem;"/>
                                        {{ $region->name }}
                                    </a>
                                    @if(!$loop->last) <span class="text-muted opacity-25">|</span> @endif
                                @endforeach
                            </div>
                        @endif

                        <div class="d-flex align-items-center flex-wrap my-2 gap-2 text-muted">
                            @if ($word->partOfSpeech)
                                <span class="fw-bold text-dark">{{ $word->partOfSpeech->name }}</span>
                                <span class="opacity-50">•</span>
                            @endif
                            <span class="font-monospace">{{ $word->characteristics }}</span>
                        </div>

                        @if ($word->labels->isNotEmpty())
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($word->labels as $label)
                                    <a href="{{ route('label:show', $label) }}" class="shadow-sm word-label text-decoration-none">
                                        <x-heroicon-o-tag class="icon me-1" style="width: 1rem;"/>
                                        {{ $label->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @auth
                        <div class="header-actions mt-4 d-flex gap-3">
                            @if ($word->bookmarkers->contains(auth()->user()))
                                <a href="{{ route('bookmark:remove', $word) }}" class="action-link-btn text-danger text-decoration-none opacity-75 d-flex align-items-center">
                                    <x-heroicon-o-bookmark-slash class="me-1" style="width:1.1rem"/> Vergeet dit woord
                                </a>
                            @else
                                <a href="{{ route('bookmark:create', $word) }}" class="action-link-btn text-decoration-none d-flex align-items-center">
                                    <x-heroicon-o-bookmark class="me-1" style="width:1.1rem"/> Bewaar
                                </a>
                            @endif

                            <button class="action-link-btn text-danger opacity-75 bg-transparent border-0 p-0 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#reportModal">
                                <x-heroicon-o-megaphone class="me-1" style="width:1.1rem"/> Verbetering melden
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    @if ($word->disclaimer)
        <div class="alert alert-info border-0 mb-0" role="alert">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <p>{{ $word->disclaimer->message }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-10">

            </div>

            <style>
                /* =========================================
   WORD TABS – LEXI STYLE
========================================= */

                .nav-tabs {
                    border-bottom: 2px solid #e9ecef;
                    gap: .5rem;
                }

                /* Reset Bootstrap default */
                .nav-tabs .nav-link {
                    border: none;
                    border-radius: 10px 10px 0 0;
                    padding: .75rem 1.25rem;
                    font-weight: 600;
                    color: #6c757d;
                    background: transparent;
                    position: relative;
                    transition: all .2s ease-in-out;
                }

                /* Hover state */
                .nav-tabs .nav-link:hover {
                    color: var(--lexi-green, #198754);
                    background: rgba(25, 135, 84, 0.05);
                }

                /* Active state */
                .nav-tabs .nav-link.active {
                    color: var(--lexi-green, #198754);
                    background: #fff;
                }

                /* Animated underline */
                .nav-tabs .nav-link::after {
                    content: "";
                    position: absolute;
                    left: 0%;
                    bottom: -2px;
                    width: 100%;
                    height: 3px;
                    background: var(--lexi-green, #198754);
                    transform: scaleX(0);
                    transform-origin: center;
                    transition: transform .25s ease;
                    border-radius: 10px;
                }

                .nav-tabs .nav-link.active::after {
                    transform: scaleX(1);
                }

                /* =========================================
                   TAB CONTENT
                ========================================= */

                .tab-content {
                    background: #ffffff;
                    padding: 2rem;
                    border-radius: 0 0 12px 12px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
                }

                /* Smooth fade */
                .tab-pane {
                    animation: fadeIn .25s ease-in-out;
                }

                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(4px); }
                    to { opacity: 1; transform: translateY(0); }
                }

                /* =========================================
                   RELATED CHIPS UPGRADE
                ========================================= */

                .related-chip {
                    display: inline-flex;
                    align-items: center;
                    padding: .45rem .75rem;
                    margin: .25rem;
                    background: #f8f9fa;
                    border-radius: 999px;
                    font-size: .85rem;
                    font-weight: 500;
                    color: #212529;
                    text-decoration: none;
                    transition: all .2s ease;
                }

                .related-chip:hover {
                    background: var(--lexi-green, #198754);
                    color: #fff;
                    transform: translateY(-2px);
                    box-shadow: 0 4px 10px rgba(25, 135, 84, 0.25);
                }

                /* =========================================
                   SOURCES LIST CLEANUP
                ========================================= */

                .source-item {
                    display: flex;
                    align-items: flex-start;
                    gap: 1rem;
                    padding: 1rem;
                    border-radius: 12px;
                    background: #f8f9fa;
                    margin-bottom: .75rem;
                    transition: all .2s ease;
                }

                .source-item:hover {
                    background: #ffffff;
                    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
                }

                .source-icon {
                    color: var(--lexi-green, #198754);
                    margin-top: 3px;
                }

                /* =========================================
                   CONTRIBUTOR BOX
                ========================================= */

                .contributor-box {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    padding: 1.25rem;
                    border-radius: 14px;
                    border: 1px solid #f1f1f1;
                    transition: all .2s ease;
                }

                .contributor-box:hover {
                    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
                    transform: translateY(-2px);
                }

                /* =========================================
                   MOBILE IMPROVEMENTS
                ========================================= */

                @media (max-width: 768px) {

                    .nav-tabs {
                        overflow-x: auto;
                        flex-wrap: nowrap;
                        scrollbar-width: none;
                    }

                    .nav-tabs::-webkit-scrollbar {
                        display: none;
                    }

                    .nav-tabs .nav-link {
                        white-space: nowrap;
                        font-size: .9rem;
                    }

                    .tab-content {
                        padding: 1.25rem;
                    }
                }

            </style>

            <div class="col-lg-7 pe-lg-5">

                {{-- Tabs Navigation --}}
                <ul class="nav nav-tabs" id="wordTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active"
                                id="definition-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#definition"
                                type="button"
                                role="tab">
                            Definitie
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link"
                                id="examples-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#examples"
                                type="button"
                                role="tab">
                            Voorbeelden
                        </button>
                    </li>

                    @if ($word->related()->exists())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link"
                                    id="related-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#related"
                                    type="button"
                                    role="tab">
                                Gerelateerd
                            </button>
                        </li>
                    @endif

                    @if($word->sources && $word->sources->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link"
                                    id="sources-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#sources"
                                    type="button"
                                    role="tab">
                                Bronnen
                            </button>
                        </li>
                    @endif
                </ul>

                {{-- Tabs Content --}}
                <div class="tab-content" id="wordTabContent">

                    {{-- Definitie --}}
                    <div class="tab-pane fade show active"
                         id="definition"
                         role="tabpanel">

                        <section>
                            <p class="mb-3 text-muted">
                                <span class="text-dark fw-bold me-2">Status:</span>
                                {{ $word->status->getLabel() }}
                            </p>

                            <div class="d-flex">
                                @if ($word->image_url)
                                    <div class="flex-shrink-0 d-sm-none d-md-block me-3">
                                        <a href="{{ $word->image_url }}">
                                            <img
                                                src="{{ $word->image_url }}"
                                                alt="{{ $word->image_alt ?? $word->word }}"
                                                class="rounded shadow-sm"
                                                style="height: 200px; width: 200px;"
                                            />
                                        </a>
                                    </div>
                                @endif

                                <div class="flex-grow-1">
                                    <div class="markdown-text lh-base text-dark">
                                        {!! str($word->description)->markdown()->sanitizeHtml() !!}
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- Voorbeelden --}}
                    <div class="tab-pane fade"
                         id="examples"
                         role="tabpanel">

                        <section>
                            <div class="markdown-text">
                                {!! str($word->example)->markdown()->sanitizeHtml() !!}
                            </div>
                        </section>
                    </div>

                    {{-- Gerelateerd --}}
                    @if ($word->related()->exists())
                        <div class="tab-pane fade"
                             id="related"
                             role="tabpanel">

                            <section>
                                <h5 class="fw-bold color-green mb-3">Gerelateerde woorden</h5>

                                <div class="d-flex flex-wrap">
                                    @foreach($word->related as $related)
                                        <a href="{{ route('word-information.show', $related) }}"
                                           class="related-chip shadow-sm">
                                            <x-heroicon-o-document-text class="icon color-green me-1"/>
                                            {{ $related->word }}
                                        </a>
                                    @endforeach
                                </div>
                            </section>
                        </div>
                    @endif

                    {{-- Bronnen --}}
                    @if($word->sources && $word->sources->count() > 0)
                        <div class="tab-pane fade"
                             id="sources"
                             role="tabpanel">

                            <section>
                                <div class="sources-list">
                                    @foreach($word->sources as $source)
                                        <div class="source-item shadow-sm @if($loop->last) mb-0 @endif">
                                            <div class="source-icon">
                                                <x-heroicon-s-book-open style="width: 1.2rem;"/>
                                            </div>
                                            <div class="flex-grow-1">
                                    <span class="fw-semibold">
                                        {{ $source->referenceWork->name }}
                                    </span>

                                                @if($source->notation)
                                                    <p class="mb-0 small text-muted mt-1">
                                                        {{ $source->notation }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        </div>
                    @endif

                </div>

                {{-- Contributor info (blijft onder tabs) --}}
                <section class="border-top pt-4 mt-4">
                    <div class="contributor-box bg-white shadow-sm">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center border"
                             style="width: 45px; height: 45px;">
                            <x-heroicon-o-user style="width: 1.5rem;" class="text-muted" />
                        </div>
                        <div>
                            <p class="mb-1 small text-muted">
                                Toegevoegd door
                                @if ($word->author()->exists())
                                    <a href="{{ route('account:public', $word->author) }}"
                                       class="fw-bold text-dark">
                                        {{ $word->author->name ?? $word->contributor_name }}
                                    </a>
                                @else
                                    <span class="fw-bold text-dark">
                            {{ $word->contributor_name }}
                        </span>
                                @endif
                            </p>

                            <p class="mb-0 small text-muted">
                                Gepubliceerd op
                                {{ optional($word->published_at)->format('d M Y') ?? $word->created_at->format('d M Y') }}
                                <span class="vr mx-2"></span>
                                Laatst bijgewerkt op
                                {{ $word->updated_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </section>

            </div>


            <aside class="col-lg-3">
                {{-- Community Stats --}}
                <livewire:voting-component :article="$word"/>
            </aside>
        </div>
    </div>

    <livewire:report-article-modal :article=$word />
@endsection
