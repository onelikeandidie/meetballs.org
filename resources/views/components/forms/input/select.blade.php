
<select {{ $attributes->merge([
    'class' => 'block p-2 text-sm text-neutral-900 bg-neutral-50 rounded-lg border border-neutral-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-900 dark:border-neutral-600 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
]) }}>
{{ $slot }}
</select>
