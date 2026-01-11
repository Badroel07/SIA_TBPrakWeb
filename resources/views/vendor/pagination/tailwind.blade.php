@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-center">
    
    {{-- Mobile Version: First, Prev, Page Indicator, Next, Last --}}
    <div class="flex sm:hidden items-center gap-1">
        {{-- First Page Button --}}
        @if ($paginator->onFirstPage())
        <span class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-xs font-bold">
            «
        </span>
        @else
        <a href="{{ $paginator->url(1) }}"
            class="flex items-center justify-center w-9 h-9 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors text-xs font-bold">
            «
        </a>
        @endif

        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
        <span class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
            class="flex items-center justify-center w-9 h-9 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        @endif

        {{-- Page Indicator --}}
        <span class="px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200">
            {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
        </span>

        {{-- Next Button --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
            class="flex items-center justify-center w-9 h-9 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
        @else
        <span class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </span>
        @endif

        {{-- Last Page Button --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->url($paginator->lastPage()) }}"
            class="flex items-center justify-center w-9 h-9 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors text-xs font-bold">
            »
        </a>
        @else
        <span class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-xs font-bold">
            »
        </span>
        @endif
    </div>

    {{-- Desktop Version: Full Page Numbers --}}
    <ul class="hidden sm:flex items-center gap-1">
        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
        <li>
            <span class="flex items-center justify-center w-10 h-10 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </li>
        @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="flex items-center justify-center w-10 h-10 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            {{-- Three Dots Separator --}}
            @if (is_string($element))
            <li>
                <span class="flex items-center justify-center w-10 h-10 text-gray-500 font-medium">{{ $element }}</span>
            </li>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <li>
                        <span class="flex items-center justify-center w-10 h-10 text-white bg-blue-600 rounded-lg font-bold shadow-md shadow-blue-200">
                            {{ $page }}
                        </span>
                    </li>
                    @else
                    <li>
                        <a href="{{ $url }}"
                            class="flex items-center justify-center w-10 h-10 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 font-medium transition-colors"
                            aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                            {{ $page }}
                        </a>
                    </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Button --}}
        @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="flex items-center justify-center w-10 h-10 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </li>
        @else
        <li>
            <span class="flex items-center justify-center w-10 h-10 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </li>
        @endif
    </ul>
</nav>
@endif