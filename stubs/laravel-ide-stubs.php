<?php

// Minimal IDE stubs for Laravel/Livewire to help static analysis (Intelephense)

namespace Illuminate\Database\Eloquent {
    class Model
    {
        public static function query(): Builder
        {
        }

        public static function find($id): ?self
        {
        }

        public static function findOrFail($id): self
        {
        }

        public static function all(): array
        {
        }

        public function fill(array $attributes): void
        {
        }

        public function save(): bool
        {
        }

        public function toArray(): array
        {
        }

        public function belongsTo(string $related)
        {
        }
    }

    class Builder
    {
        public function orderBy($column, $direction = 'asc'): self
        {
        }

        public function paginate($perPage = null)
        {
        }

        public function tap(callable $callback): self
        {
        }
    }

    class Relation
    {
    }
}

namespace Illuminate\Support\Facades {
    class Log
    {
        public static function error(string $message): void
        {
        }
    }
}

namespace Livewire {
    class Form
    {
        public function validate(): void
        {
        }

        public function fill(array $data): void
        {
        }

        public function reset(): void
        {
        }

        public function toArray(): array
        {
        }
    }
}

namespace Flux {
    class Modal
    {
        public function show(): void
        {
        }

        public function close(): void
        {
        }
    }

    class Flux
    {
        public static function modal(string $name): Modal
        {
        }

        public static function toast(...$args): void
        {
        }
    }
}
