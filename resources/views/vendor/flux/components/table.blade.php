{{--
If you still get "Unable to locate a class or view for component [flux::table]",
try using your own custom component registration in a service provider:

// In AppServiceProvider or a custom provider:
use Illuminate\Support\Facades\Blade;
Blade::component('vendor.flux.components.table', 'flux::table');

Then use <x-flux::table>...</x-flux::table> in your Blade views.
--}}
<table {{ $attributes->merge(['class' => 'min-w-full border-collapse']) }}>
    {{ $slot }}
</table>
