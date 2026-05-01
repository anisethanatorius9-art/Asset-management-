<?php

// IDE / static analysis stubs for missing Livewire types

namespace Livewire {
    // Minimal stubs so static analyzers (Intelephense) can resolve these types
    trait WithPagination {}
    trait WithoutUrlPagination {}
}

namespace Livewire\Attributes {
    use Attribute;

    #[Attribute(Attribute::TARGET_METHOD)]
    class Computed {}
}
